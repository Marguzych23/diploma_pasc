<?php


namespace App\Admin;


use App\Entity\ApiSubscriber;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EmailSubscriberAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class);
        $formMapper->add('email', TextType::class);
//        $formMapper->add('industries', TextType::class);
        $formMapper->add('lastNotifyDate', DateTimeType::class);
        $formMapper->add('emailNotify', CheckboxType::class);
        $formMapper->add('lastEmailNotifyDate', DateTimeType::class);
        $formMapper->add('apiSubscriber', ModelType::class, [
            'class' => ApiSubscriber::class,
            'property' => 'name',
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('email');
//        $datagridMapper->add('industries');
        $datagridMapper->add('lastNotifyDate');
        $datagridMapper->add('emailNotify');
        $datagridMapper->add('lastEmailNotifyDate');
//        $datagridMapper->add('apiSubscriber');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->add('email');
//        $listMapper->add('industries');
        $listMapper->add('lastNotifyDate');
        $listMapper->add('emailNotify');
        $listMapper->add('lastEmailNotifyDate');
//        $listMapper->add('apiSubscriber');
    }
}