<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompetitionAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class);
        $formMapper->add('name', TextType::class);
        $formMapper->add('deadline', DateType::class);
//        $formMapper->add('industries', DateType::class);
        $formMapper->add('grantSize', TextType::class);
        $formMapper->add('url', TextType::class);
        $formMapper->add('updateDate', DateType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('name');
        $datagridMapper->add('deadline');
        $datagridMapper->add('grantSize');
        $datagridMapper->add('url');
        $datagridMapper->add('updateDate');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->add('name');
        $listMapper->add('deadline');
        $listMapper->add('grantSize');
        $listMapper->add('url');
        $listMapper->add('updateDate');
    }
}