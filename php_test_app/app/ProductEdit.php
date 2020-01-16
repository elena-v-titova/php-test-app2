<?php

/**
 * The class describes edit actions for a Product.
 */

class ProductEdit
{
    /**
     * The method creates
     *  - an empty form for creating a product, or
     *  - the form with fields mark as error if a new Product was not created, or
     *  - the new Product and save it in database.
     *
     * Return the template parametrs.
     * @return array
     */
    static public function create($entityManager)
    {
        $templateParams = [
            'template' => 'create_product.phtml',
            'params'   => [
                'title' => 'Добавление нового товара'
            ]
        ];

        if (isset($_POST) and $_POST['create_product']) {
            $productForm = new ProductForm();
            $productForm->check();

            if ($productForm->isError()) {
                $templateParams['params']['form_error'] = $productForm->getErrors();
            } else {
                $pdb = new ProductDB($entityManager);

                $product = new Product();
                $product->setName($productForm->getName());
                $product->setQuantity($productForm->getQuantity());
                $product->setPrice($productForm->getPrice());
                $templateParams['params']['product'] = $product;

                if ($pdb->getByName($productForm->getName())) {
                    $templateParams['params']['exist_error'] = 'Товар '.
                       $productForm->getName(). ' уже существует';
                } else {
                    $pdb->save($product);
                }
            }
        }

        return $templateParams;
    }
}

