<?php

/*
 * Plugin Name: logsurveil
 * 
 * Description:       plugin permettant la surveillance des logs sur les différentes pages du site
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gaetan
 * Author URI:        https://chat.openai.com/chat
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

// 1 exercice simple
// filtrer l'affichage du champs page_link pour ne laisser que le nom de la page.

// 2 exercice moyen
// ajouter un bouton qui permet changer le nombre de ligne afficher

// 3 ajouter un bouton qui permet de purger la base de log

// 4 exercice un peu plus difficile
// ajouter un checkbox et un bouton qui permetent de supprimer des lignes de log 
// permet de de gérer les versions et de modifier la table avec les mises à jour du plugin


// 5 exercices cauchemardesque
// ajouter un lien sur ip_address qui trouve l'ip de l'utilisateur et ajouter le pays dans la base de données
// la difficulté est de trouver l'api whois gratuite..

add_option("jal_db_version", "1.3");

// require_once __DIR__ . '/lib/statistiques.php';

/**
 * installLogTable créer la table wp_plugin_log
 * avec les champ ip_address  page_link et create_at
 *
 * @return void
 */
function installLogTable()
{
    global $wpdb;
    global $jal_db_version;

    $charset_collate = $wpdb->get_charset_collate();

    $xblog_table_name = $wpdb->prefix . 'plugin_log'; // Remplacez "nom_de_la_table" par le nom de votre choix

    $sql = "CREATE TABLE $xblog_table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
		ip_address VARCHAR(50) NOT NULL,
		page_link VARCHAR(255) NOT NULL,
  		create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


    dbDelta($sql);
}

register_activation_hook(__FILE__, 'installLogTable');




/**
 * log_update_db_check check la version du plugin
 * 
 *
 * @return void
 */
function log_update_db_check()
{
    global $jal_db_version;
    if (get_site_option('jal_db_version') != $jal_db_version) {
        installLogTable();
    }
}

// quand le plugin est chargé on vérifie si la version est mise à jour
add_action('plugins_loaded', 'log_update_db_check');

/**
 * La fonction wp_plugin_log_user_ip utilise la variable global $wpdb pour accéder à l'objet de la base de données WordPress.
 * Elle utilise la fonction $_SERVER['REMOTE_ADDR'] pour obtenir l'adresse IP de l'utilisateur qui visite l'article ou la page.
 * Elle utilise la fonction get_permalink() pour obtenir l'URL de la page ou de l'article en cours de visite.
 * Elle utilise la méthode $wpdb->insert() pour insérer les informations dans la table wp_plugin_log. Cette méthode prend trois arguments : le nom de la table, un tableau associatif contenant les valeurs à insérer, et un tableau indiquant le type de chaque valeur.
 *
 * @return void
 */
function wp_plugin_log_user_ip()
{
    global $wpdb;
    //var_dump("ip_address: ", $_SERVER['REMOTE_ADDR'], "page_link: ", get_permalink());

    if (wp_plugin_check_local_url(get_site_url())) {
        $ip_address = generate_random_ip();
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }

    $page_link = get_permalink();
    $xblog_table_name = $wpdb->prefix . 'plugin_log';
    $wpdb->insert(
        $xblog_table_name,
        array(
            'ip_address' => $ip_address,
            'page_link' => $page_link,
        ),
        array(
            '%s',
            '%s'
        )
    );
}
add_action('wp', 'wp_plugin_log_user_ip');

/**
 * La fonction wp_plugin_log_admin_menu utilise la fonction add_menu_page() pour ajouter une nouvelle page dans la section d'administration de WordPress. Cette page affichera les informations stockées dans la table wp_plugin_log. 
 *
 * @return void
 */
function wp_plugin_log_admin_menu()
{
    add_menu_page('Plugin Log', 'Plugin Log', 'manage_options', 'wp_plugin_log', 'wp_plugin_log_page');

    add_submenu_page('wp_plugin_log', 'Purge Log Database', 'Purge Database', 'manage_options', 'wp_plugin_log_purge_database', 'wp_plugin_log_purge_database');
}
/**
 * La fonction add_action() est utilisée pour appeler la fonction wp_plugin_log_admin_menu lorsque WordPress charge la section d'administration.
 */
add_action('admin_menu', 'wp_plugin_log_admin_menu');

/**
 * La fonction wp_plugin_log_page récupère les informations de la table wp_plugin_log en utilisant la méthode $wpdb->get_results(). Elle boucle ensuite sur chaque ligne de la table pour afficher les informations dans un tableau HTML. Undocumented function
 *
 * @return void
 */
function wp_plugin_log_page()
{
    global $wpdb;

    $xblog_table_name = $wpdb->prefix . 'plugin_log';

    // If form is submitted, delete selected logs
    if (isset($_POST['delete_logs']) && isset($_POST['logs'])) {
        $logs_to_delete = $_POST['logs'];
        foreach ($logs_to_delete as $log_id) {
            $wpdb->delete($xblog_table_name, array('id' => $log_id), array('%d'));
        }
        echo '<div class="notice notice-success is-dismissible"><p>Selected logs have been deleted successfully!</p></div>';
    }

    $per_page = isset($_POST['per_page']) ? $_POST['per_page'] : 10;
    ////////
    // echo "<form method='post' action=''>";
    // echo "<label>Nombre de résultats par page : </label>";
    // echo "<input type='number' name='per_page' label='per_page'>"; 
// /////////
    echo "<form method='post' >";
    echo "<label>Nombre de resultat par page :";

    echo "<select name='per_page'>";
    echo "<option value='5' >5</option>";
    echo "<option value='10' selected>10</option>";
    echo "<option value='20'>20</option>";
    echo "</select>";
    echo "<input type='submit'>";
    echo "</form>";

    // Pagination
    isset($_REQUEST['paged']) ? $current_page = $_REQUEST['paged'] : $current_page = 1;
    //$per_page = 10;
    $offset = ($current_page - 1) * $per_page;
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $xblog_table_name");
    $total_pages = ceil($total_items / $per_page);


    // Tri
    $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'create_at';
    $order = isset($_GET['order']) ? $_GET['order'] : 'desc';
    $order_link = ($order == 'asc') ? 'desc' : 'asc';

    // Récupérer les logs
    //$logs = $wpdb->get_results( "SELECT * FROM $xblog_table_name ORDER BY create_at DESC LIMIT $per_page OFFSET $offset" );
    $logs = $wpdb->get_results("SELECT * FROM $xblog_table_name ORDER BY $orderby $order LIMIT $per_page OFFSET $offset");

    /**
     * La boucle `foreach` est utilisée pour afficher les informations récupérées de la base de données 
     * dans un tableau HTML.
     */
    echo '<h2>Plugin Log</h2>';
    // Display logs in table format with checkboxes
    echo '<form method="post" action="">';
    echo '<table>';
    //echo '<tr><th>IP Address</th><th>Page Link</th><th>Date</th></tr>';

    $html = '<tr><th>
	<a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_plugin_log&orderby=ip_address&order=' . $order_link . '">IP Address
	</a></th><th><a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_plugin_log&orderby=page_link&order=' . $order_link . '">Page Link
	</a></th><th><a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_plugin_log&orderby=create_at&order=' . $order_link . '">Date
	</a></th></tr>';
    echo htmlspecialchars_decode($html);
    echo '<thead><tr><th>Select</th><th>ID</th><th>IP Address</th><th>Page Link</th><th>Created At</th></tr></thead>';
    echo '<tbody>';
    foreach ($logs as $log) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="logs[]" value="' . $log->id . '"></td>';
        echo '<td>' . $log->id . '</td>';
        echo '<td>' . $log->ip_address . '</td>';
        echo '<td>' . get_page_name_from_url($log->page_link) . '</td>';
        echo '<td>' . $log->create_at . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '<br>';
    echo '<input type="submit" name="delete_logs" value="Delete Selected Logs" class="button button-primary">';
    echo '</form>';

    // Variables utilisées pour le debug
    // var_dump("total_items",$total_items);
    // var_dump("current_page",$current_page);
    // var_dump("offset",$offset);
    // var_dump($_REQUEST);

    // Afficher la pagination	
    echo '<div class="pagination">';
    $format = 'page/%#%/';
    // La fonction `paginate_links()` est utilisée pour afficher les liens de pagination.
// Cette fonction prend un tableau d'options, y compris la base des liens,
// le format des liens, le texte pour les liens "Précédent" et "Suivant", 
//le nombre total de pages et la page actuelle.
    echo paginate_links(
        array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => $format,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'total' => $total_pages,
            'current' => $current_page
        )
    );
    echo '</div>';

    plugin_stats();

}


function wp_plugin_log_purge_database()
{
    global $wpdb;
    $xblog_table_name = $wpdb->prefix . 'plugin_log';
    $wpdb->query("TRUNCATE TABLE $xblog_table_name");
}

/**
 * La fonction prend une URL en tant que paramètre.
 * Elle crée un tableau contenant les hôtes locaux valides ('localhost', '127.0.0.1').
 * Elle utilise la fonction parse_url() pour extraire le nom d'hôte de l'URL et le stocke dans la variable $host.
 * Si $host est présent dans le tableau $local_hosts, la fonction renvoie true, sinon elle renvoie false.
 */

function wp_plugin_check_local_url($url)
{
    $local_hosts = array('localhost', '127.0.0.1');
    $parsed_url = parse_url($url);
    if (isset($parsed_url['host'])) {
        $host = $parsed_url['host'];
        if (in_array($host, $local_hosts)) {
            return true;
        }
    }
    return false;
}


/**
 * La fonction generate_random_ip utilise une boucle for pour générer quatre nombres aléatoires entre 0 et 255.
 * Elle stocke ces nombres dans un tableau $ip.
 * Elle utilise la fonction implode pour fusionner les nombres en une chaîne de caractères séparée par des points, qui représente l'adresse IP aléatoire.
 * L'exemple d'utilisation montre comment appeler la fonction et stocker le résultat dans une variable $random_ip.
 * Enfin, le code affiche l'adresse IP aléatoire en utilisant la fonction echo.
 * N'oubliez pas que cette adresse IP aléatoire ne correspond pas à une véritable adresse IP et qu'elle ne doit pas être utilisée dans un contexte de production.
 */

function generate_random_ip()
{
    $ip = array();
    for ($i = 0; $i < 4; $i++) {
        $ip[] = rand(0, 255);
    }
    return implode('.', $ip);
}

/**
 * Undocumented function
 * Cette fonction utilise la fonction parse_url() pour extraire le chemin de l'URL, puis la fonction explode() 
 * pour séparer le chemin en segments. 
 * La fonction end() est utilisée pour récupérer le dernier segment, qui est le nom de la page.
 * @param [type] $url
 * @return void
 */
function get_page_name_from_url($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $segments = explode('/', rtrim($path, '/'));
    return end($segments);
}


function plugin_stats()
{
    global $wpdb; // Accéder à la base de données Wordpress

    $total_visitors = $wpdb->get_var("SELECT COUNT(DISTINCT ip_address) FROM {$wpdb->prefix}plugin_log"); // Nombre total de visiteurs uniques
    $total_visits = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}plugin_log"); // Nombre total de visites

    $most_visited_pages = $wpdb->get_results("
        SELECT page_link, COUNT(*) as visit_count
        FROM {$wpdb->prefix}plugin_log
        GROUP BY page_link
        ORDER BY visit_count DESC
        LIMIT 5"); // Les 5 pages les plus visitées, triées par nombre de visites décroissant

    $recent_visitors = $wpdb->get_results("
        SELECT DISTINCT ip_address, create_at
        FROM {$wpdb->prefix}plugin_log
        ORDER BY create_at DESC
        LIMIT 10"); // Les 10 visiteurs les plus récents

    // Afficher les résultats
    echo "<p>Nombre total de visiteurs uniques: $total_visitors</p>";
    echo "<p>Nombre total de visites: $total_visits</p>";
    echo "<p>Pages les plus visitées:</p>";
    echo "<ul>";
    foreach ($most_visited_pages as $page) {
        echo "<li>{$page->page_link} ({$page->visit_count} visites)</li>";
    }
    echo "</ul>";
    echo "<p>Visiteurs récents:</p>";
    echo "<ul>";
    foreach ($recent_visitors as $visitor) {
        echo "<li>{$visitor->ip_address} ({$visitor->create_at})</li>";
    }
    echo "</ul>";
}