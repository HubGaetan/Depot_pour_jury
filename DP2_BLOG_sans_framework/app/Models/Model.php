<?php

namespace App\Models;

use PDO;
use Database\DBConnection;

abstract class Model
{

    // definition de la connexion a la base de données
    protected $db;
    // definition de la table sur laquelle on veut travailler
    protected $table;

    /**
     * on recupere la connection a la base de données
     * Summary of __construct
     * @param DBConnection $db
     */
    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

    /**
     * Summary of all
     * permet de récupérer l'ensemble des elements  de $this->table
     * @return array
     */
    public function all(): array
    {
        return $this->query("SELECT * FROM {$this->table} "); //BUG avec tag ORDER BY created_at DESC
    }

    /**
     * Summary of findByid
     * permet de récupérer les elements de $this->table where id = $id
     * @param int $id
     * @return Model
     */
    public function findByid(int $id): Model
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    /**
     * Summary of create
     * permet de créer une nouvelle "instance" de la table $this->table
     * @param array $data
     * @param array|null $relations
     * @return mixed
     */
    public function create(array $data, ?array $relations = null)
    {
        $firstParenthesis = "";
        $secondParenthesis = "";
        $i = 1;

        // refactorisation du code pour ecrire la requete sql
        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ", ";
            $firstParenthesis .= "{$key}{$comma}";
            $secondParenthesis .= ":{$key}{$comma}";
            $i++;
        }

        return $this->query("INSERT INTO {$this->table} ($firstParenthesis)
        VALUES($secondParenthesis)", $data);
    }

    /**
     * Summary of update
     * @param int $id
     * @param array $data
     * @param array|null $relations
     * @return mixed
     */
    public function update(int $id, array $data, ?array $relations = null)
    {
        $sqlRequestPart = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data['id'] = $id;

        return $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id", $data);
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * Summary of query
     * la methode query permet de generer les requetes sql pour le CRUD
     * en fonction des parametre on pourra 
     * @param string $sql
     * @param array|null $param
     * @param bool|null $single
     * @return mixed
     */
    public function query(string $sql, array $param = null, bool $single = null)
    {
        // si il n'y a pas de données dans $param utlise la méthode "query" sinon "la méthode "prepare" 
        $method = is_null($param) ? 'query' : 'prepare';

        // si le premier mot de la requete sql est DELETE, UPDATE OU INSERT
        if (
            strpos($sql, 'DELETE') === 0
            || strpos($sql, 'UPDATE') === 0
            || strpos($sql, 'INSERT') === 0
        ) {
            // on prepare la requete a envoyer a la base de données
            $stmt = $this->db->getPDO()->$method($sql);
            // permet de demander a PDO de renvoyer la reponse sous forme objet
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
            // execution de la transaction
            return $stmt->execute($param);
        }
        // si le parametre single est null faire un fetchall sinon un fetch
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';
        // on prepare la requete a envoyer a la base de données
        $stmt = $this->db->getPDO()->$method($sql);
        // permet de demander a PDO de renvoyer la reponse sous forme objet
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        if ($method === 'query') {
            return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }
}