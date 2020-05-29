<?php


namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IndustryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class);
        $formMapper->add('name', TextType::class);
//        $formMapper->add('competitions', DateType::class);
//        $formMapper->add('supportSitesIndustries', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('name');
//        $datagridMapper->add('competitions');
//        $datagridMapper->add('supportSitesIndustries');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->add('name');
//        $listMapper->add('competitions');
//        $listMapper->add('supportSitesIndustries');
    }
}