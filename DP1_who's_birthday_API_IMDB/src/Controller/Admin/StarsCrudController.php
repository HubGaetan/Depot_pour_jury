<?php

namespace App\Controller\Admin;

use App\Entity\Stars;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StarsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stars::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('star')
            ->setEntityLabelInPlural('stars')
            ->setPageTitle("index", "administration des stars")
            ->setPaginatorPageSize(10);
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name'),
            TextField::new('Birthday'),
            TextField::new('birthplace'),
            Field::new('height'),
            TextEditorField::new('biography')
                ->hideOnIndex()
        ];
    }
}
