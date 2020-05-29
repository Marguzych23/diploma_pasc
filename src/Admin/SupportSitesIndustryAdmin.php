<?php


namespace App\Admin;

use App\Entity\Industry;
use App\Entity\SupportSite;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SupportSitesIndustryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id', IntegerType::class);
        $formMapper->add('keywords', TextType::class);
        $formMapper->add('industry', ModelType::class, [
            'class' => Industry::class,
            'property' => 'name',
        ]);
        $formMapper->add('supportSite', ModelType::class, [
            'class' => SupportSite::class,
            'property' => 'name',
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('keywords');
//        $datagridMapper->add('industry');
//        $datagridMapper->add('supportSite');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('id');
        $listMapper->add('keywords');
//        $listMapper->add('industry');
//        $listMapper->add('supportSite');
    }
}