<?php

namespace Erichard\DmsBundle\Twig;

use Erichard\DmsBundle\DocumentInterface;
use Symfony\Component\Routing\RouterInterface;

class DmsExtension extends \Twig_Extension
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters()
    {
        return array(
            'filesize' => new \Twig_Filter_Method($this, 'getFileSize')
        );
    }

    public function getFunctions()
    {
        return array(
            'thumbUrl' => new \Twig_Function_Method($this, 'getThumbUrl')
        );
    }

    public function getFileSize($sizeInBytes)
    {
        $unit=array('b','kb','mb','gb','tb','pb');

        return @round($sizeInBytes/pow(1024,($i=floor(log($sizeInBytes,1024)))),2).' '.$unit[$i];
    }

    public function getThumbUrl(DocumentInterface $document, $dimension, $absolute = false)
    {
        return $this->router->generate('erichard_dms_document_preview', array(
            'document'    => $document->getSlug(),
            'node'        => $document->getNode()->getSlug(),
            'dimension'   => $dimension,
        ), $absolute);
    }

    public function getName()
    {
        return "dms_extension";
    }
}
