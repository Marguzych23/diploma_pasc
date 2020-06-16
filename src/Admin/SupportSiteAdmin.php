<?php


namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SupportSiteAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class);
        $formMapper->add('name', TextType::class);
        $formMapper->add('abbreviation', TextType::class);
        $formMapper->add('url', TextType::class);
        $formMapper->add('competitions_page_url', TextType::class);
//        $formMapper->add('supportSitesIndustries', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('name');
        $datagridMapper->add('abbreviation');
        $datagridMapper->add('url');
        $datagridMapper->add('competitions_page_url');
//        $datagridMapper->add('supportSitesIndustries');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->add('name');
        $listMapper->add('abbreviation');
        $listMapper->add('url');
        $listMapper->add('competitions_page_url');
//        $listMapper->add('supportSitesIndustries');
    }
}