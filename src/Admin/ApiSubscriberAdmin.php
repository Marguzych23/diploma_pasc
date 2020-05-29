<?php


namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ApiSubscriberAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class);
        $formMapper->add('name', TextType::class);
        $formMapper->add('token', TextType::class);
        $formMapper->add('lastGetAllDate', DateTimeType::class);
        $formMapper->add('subscribeDate', DateTimeType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('name');
        $datagridMapper->add('token');
        $datagridMapper->add('lastGetAllDate');
        $datagridMapper->add('subscribeDate');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->add('name');
        $listMapper->add('token');
        $listMapper->add('lastGetAllDate');
        $listMapper->add('subscribeDate');
    }
}