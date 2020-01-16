<?php

/**
 * The class for the product database repository
 */
class ProductDB
{
    /**
     * The database
     */
    private $db;
    private $entityClass = 'Product';

    public function __construct($dbh)
    {
        $this->db = $dbh;
    }

    /**
     * Save the Product in the database.
     *
     * @param Product
     */
    public function save(Product $p)
    {
        $sql = "INSERT INTO $this->entityClass (name, quantity, price) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $p->getName());
        $stmt->bindParam(2, $p->getQuantity());
        $stmt->bindParam(3, $p->getPrice());
        $stmt->execute();
    }

    /**
     * Return all Products from the database.
     *
     * @return Product[]
     */
    public function getAll()
    {
        $sql = "SELECT * from $this->entityClass";
        $stmt = $this->db->query($sql);

        $products = array();
        while ($p = $stmt->fetchObject($this->entityClass)) {
            $product[] = $p;
        }

        return $product;
    }

    /**
     * Return the Product by name from the database.
     *
     * @return Product|false
     */
    public function getByName($name)
    {
        $sql = "SELECT * from $this->entityClass WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($name));
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);
        $product = $stmt->fetch();

        return $product;
    }
}

