-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 06 mars 2023 à 15:41
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `myapp`
--

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE `medias` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alttext` text NOT NULL,
  `name_media` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`id`, `path`, `name`, `alttext`, `name_media`) VALUES
(71, 'images/img03.jpg', '', '', ''),
(75, 'images/img04.jpg', '', '', ''),
(80, 'images/img05.jpg', '', '', ''),
(87, 'images/img02.jpg', '', '', ''),
(96, 'images/Test-Appartement-pied-micro-Dollhouse-View.jpg', '', '', ''),
(97, 'images/oursb.jpg', '', '', ''),
(98, 'images/orsopolareartico.jpg', '', '', ''),
(101, 'images/ourspolaire.jpg', '', '', ''),
(102, 'images/330px-OursChaparriF_(1)[2].jpg', '', '', ''),
(103, 'images/435px-Ursus_thibetanus_3_(Wroclaw_zoo)[1].JPG', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`) VALUES
(8, 'Albinoni', '   omaso Giovanni Albinoni (8 June 1671 – 17 January 1751) was an Italian composer of the Baroque era. His output includes operas, concertos, sonatas for one to six instruments, sinfonias, and solo cantatas.[1] While famous in his day as an opera composer, he is known today for his instrumental music, especially his concertos.[2] He is best remembered today for a work called \"Adagio in G minor\", attributed to him but largely written by Remo Giazotto, a 20th century musicologist and composer, who was a cataloger of the works of Albinoni.[3]   ', '2022-11-29 10:53:55'),
(9, 'Picasso', '   In this Spanish name, the first or paternal surname is Ruiz and the second or maternal family name is Picasso.\r\nPablo PicassoGG\r\nPortrait de Picasso, 1908.jpgGG\r\nPicasso in 1908\r\nBorn	Pablo Diego José Francisco de Paula Juan Nepomuceno María de los Remedios Cipriano de la Santísima Trinidad Ruiz y Picasso[1]\r\n25 October 1881\r\nMálaga, Kingdom of Spain\r\nDied	8 April 1973 (aged 91)\r\nMougins, France\r\nResting place	Château of Vauvenargues\r\n43.554142°N 5.604438°E\r\nEducation	\r\nJosé Ruiz y Blasco (father)\r\nReal Academia de Bellas Artes de San Fernando\r\nKnown for	Painting, drawing, sculpture, printmaking, ceramics, stage design, writing\r\nNotable work	\r\nLa Vie (1903)\r\nFamily of Saltimbanques (1905)\r\nLes Demoiselles dGGAvignon (1907)\r\nPortrait of Daniel-Henry Kahnweiler (1910)\r\nGirl before a Mirror (1932)\r\nLe Rêve (1932)\r\nGuernica (1937)\r\nThe Weeping Woman (1937)\r\nMassacre in Korea (1951)\r\nMovement	Cubism, Surrealism\r\nSpouses	\r\nOlga Khokhlova\r\n​\r\n​(m. 1918; died 1955)​\r\nJacqueline Roque ​(m. 1961)​\r\nPartners	\r\nMarie-Thérèse Walter (1927–1935)\r\nDora Maar (1935–1943)\r\nFrançoise Gilot (1943–1953)\r\nChildren	\r\nPaulo Picasso\r\nMaya Widmaier-Picasso\r\nClaude Picasso\r\nPaloma Picasso\r\nFamily	\r\nMarina Picasso (granddaughter)\r\nBernard Ruiz-Picasso (grandson)\r\nPatron(s)	Sergei Shchukin\r\nSignature\r\nPicasso Signatur-DuMont 1977.svg\r\nPablo Ruiz Picasso[a][b] (25 October 1881 – 8 April 1973) was a Spanish painter, sculptor, printmaker, ceramicist and theatre designer who spent most of his adult life in France. One of the most influential artists of the 20th century, he is known for co-founding the Cubist movement, the invention of constructed sculpture,[8][9] the co-invention of collage, and for the wide variety of styles that he helped develop and explore. Among his most famous works are the proto-Cubist Les Demoiselles dGGAvignon (1907), and the anti-war painting Guernica (1937), a dramatic portrayal of the bombing of Guernica by German and Italian air forces during the Spanish Civil War.\r\n\r\nPicasso demonstrated extraordinary artistic talent in his early years, painting in a naturalistic manner through his childhood and adolescence. During the first decade of the 20th century, his style changed as he experimented with different theories, techniques, and ideas. After 1906, the Fauvist work of the slightly older artist Henri Matisse motivated Picasso to explore more radical styles, beginning a fruitful rivalry between the two artists, who subsequently were often paired by critics as the leaders of modern art.[10][11][12][13]   ', '2022-11-29 10:55:38'),
(13, 'Maurits Cornelis Escher', 'Maurits Cornelis Escher1, né le 17 juin 1898 à Leeuwarden et mort le 27 mars 1972 à Laren, plus couramment nommé M. C. Escher, est un artiste néerlandais, connu pour ses gravures sur bois, manières noires et lithographies souvent inspirées des mathématiques et des motifs de l\'art islamique. Au cours de sa vie, il a réalisé 448 estampes, et plus de 2 000 dessins et esquisses. Il a également illustré des livres, des tapisseries, des timbres et des œuvres murales.\r\n\r\nSes œuvres représentent des constructions impossibles, des explorations de l\'infini, des pavages et des combinaisons de motifs en deux ou trois dimensions qui se transforment graduellement en des formes totalement différentes, qui défient les modes habituels de représentation du spectateur.\r\n\r\nL\'œuvre de M. C. Escher a séduit de nombreux mathématiciens à la communauté desquels il se défendait d\'appartenir. Il aimait dire à ses admirateurs : « Tout cela n\'est rien comparé à ce que je vois dans ma tête ! »', '2022-12-05 10:07:17'),
(14, 'Franz Schubert', '   Compositeur emblématique de la musique romantique allemande, il est reconnu comme le maître incontesté du lied. Il s\'est particulièrement consacré à la musique de chambre, et a aussi écrit de nombreuses œuvres pour piano, une dizaine de symphonies, ainsi que de la musique chorale et sacrée.\r\n\r\nBien qu\'il soit mort précocement, à 31 ans, Schubert est l\'un des compositeurs les plus prolifiques du xixe siècle. Le catalogue de ses œuvres compte plus de mille compositions, dont une partie importante est publiée après sa mort et révèle des chefs-d\'œuvre qui contribuent à sa renommée posthume. ', '2022-12-05 10:10:07'),
(25, 'Léonard de Vinci', 'Léonard de Vinci (italien : Leonardo di ser Piero da VinciÉcouter, dit Leonardo da Vinci), né le 14 avril 1452 du calendrier actuel à Vinci (Toscane) et mort le 2 mai 1519 à Amboise (Touraine), est un peintre italien polymathe, à la fois artiste, organisateur de spectacles et de fêtes, scientifique, ingénieur, inventeur, anatomiste, sculpteur, peintre, architecte, urbaniste, botaniste, musicien, philosophe et écrivain.\r\n\r\nEnfant naturel d\'une paysanne, Caterina di Meo Lippi et d\'un notaire, Pierre de Vinci, il est élevé auprès de ses grands-parents paternels dans la maison familiale de Vinci jusqu’à l’âge de dix ans. À Florence, son père l\'inscrit pour deux ans d’apprentissage dans une scuola d’abaco et ensuite à l\'atelier d\'Andrea del Verrocchio où il côtoie Botticelli, Le Pérugin et Domenico Ghirlandaio.\r\n\r\nIl quitte l’atelier en 1482 et se présente principalement comme ingénieur au duc de Milan Ludovic Sforza. Introduit à la cour, il obtient quelques commandes de peinture et ouvre un atelier. Il étudie les mathématiques et le corps humain. Il rencontre également Gian Giacomo Caprotti, dit Salai, un enfant de dix ans, turbulent élève de son atelier, qu’il prend sous son aile.\r\n\r\nEn septembre 1499, Léonard part à Mantoue, à Venise et retourne à Florence. Il y repeint et s\'adonne à l’architecture ainsi qu\'à l\'ingénierie militaire. Pendant un an, il confectionne des cartes géographiques pour César Borgia.\r\n\r\nEn 1503, la ville de Florence lui commande une fresque, mais il en est déchargé par le roi de France Louis XII qui l\'appelle à Milan où, de 1506 à 1511, il est « peintre et ingénieur ordinaire » du souverain. Il rencontre Francesco Melzi, son élève, ami et exécuteur testamentaire. En 1504, son père meurt, mais il est exclu du testament. En 1507, il est usufruitier des terres de son oncle décédé.', '2023-01-27 11:25:27'),
(26, 'Giorgio Vasari', 'Giorgio Vasari (30 juillet 1511 à Arezzo - 27 juin 1574 à Florence) est un peintre, architecte et écrivain toscan. Son recueil biographique Les Vies des meilleurs peintres, sculpteurs et architectes, particulièrement sa seconde édition de 1568, est considéré comme une des publications fondatrices de l\'histoire de l\'art.\r\n\r\n...', '2023-01-27 11:26:46'),
(27, 'Jehan-Rictus', 'Gabriel Randon de Saint-Amand, initialement Gabriel Randon, qui prit le pseudonyme de Jehan Rictus ([ʒeã ʁiktys] ou [ʒøã ʁiktys] ou [ʒã ʁiktys]) (Jehan-Rictus avec un trait d\'union à partir de 19221), est né à Boulogne-sur-Mer le 21 septembre 1867 et mort à Paris le 6 novembre 1933. C\'est un poète français, célèbre pour ses œuvres composées dans la langue du peuple du Paris de son époque.\r\n</br></br>\r\nSes poèmes se trouvent principalement réunis dans deux livres, Les Soliloques du pauvre et ... le Cœur populaire. Le premier fait soliloquer un sans-logis contraint d\'errer dans Paris, le second divers personnages : prostituées, enfants battus, ouvriers, cambrioleurs, etc.\r\n</br></br>\r\nhttps://fr.wikipedia.org/wiki/Jehan-Rictus', '2023-01-27 11:35:40'),
(91, 'ours blanc', 'Quattro volte l’energia rispetto alle storiche condizioni dei loro habitat: questo quanto serve agli orsi polari e agli altri mammiferi dell’Artico per adattarsi ai cambiamenti climatici. Come riporta Agi lo rivela una ricerca pubblicata sul Journal of Experimental Biology incentrata sulle conseguenze dell’assottigliamento dello strato di ghiaccio per le specie animali che nascono e vivono a quelle latitudini. Le emissioni di gas serra e il riscaldamento globale stanno profondamente trasformando il clima dell’Artico, obbligando animali quali orsi polari e narvali a consumare molte più energie per sopravvivere in un ambiente in rapida trasformazione. In effetti, secondo vari studi il mare di ghiaccio sul quale gli orsi polari sono abituati a cacciare è diminuito del 13% in media per ogni decennio trascorso a partire dal 1979.', '2023-02-27 14:36:58');

-- --------------------------------------------------------

--
-- Structure de la table `post_media`
--

CREATE TABLE `post_media` (
  `post_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post_media`
--

INSERT INTO `post_media` (`post_id`, `media_id`) VALUES
(8, 71),
(9, 75),
(9, 80),
(8, 75),
(91, 98),
(91, 97),
(91, 101),
(8, 102),
(8, 103);

-- --------------------------------------------------------

--
-- Structure de la table `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post_tag`
--

INSERT INTO `post_tag` (`post_id`, `tag_id`) VALUES
(26, 1),
(27, 5),
(25, 3),
(13, 5),
(9, 2),
(91, 1),
(91, 3),
(91, 4),
(91, 5),
(91, 8),
(8, 2),
(8, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'peinture'),
(2, 'cinéma'),
(3, 'mathématiques'),
(4, 'musique'),
(5, 'littérature'),
(6, 'newtags'),
(7, 'newnewtag'),
(8, 'Nature');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `admin`) VALUES
(1, 'admin', '$2y$10$x1HaLhyop9TKKX3DzcCgCO./OZQNwgL9jzffWF49jN85dDwtx31C6', 1),
(2, 'user1', '$2y$10$sin9mDJwXNtkA0g5krhbsOCxAV/I74KKEbuC1z5ErQzoFaOYyK7Fm', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `medias` ADD FULLTEXT KEY `path` (`path`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `post_media`
--
ALTER TABLE `post_media`
  ADD KEY `post_tag_ibfk_1` (`post_id`),
  ADD KEY `post_media_ibfk_1` (`media_id`);

--
-- Index pour la table `post_tag`
--
ALTER TABLE `post_tag`
  ADD KEY `post_tag_ibfk_1` (`post_id`),
  ADD KEY `post_tag_ibfk_2` (`tag_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post_media`
--
ALTER TABLE `post_media`
  ADD CONSTRAINT `post_media_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
