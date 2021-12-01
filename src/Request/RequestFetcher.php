<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Ci\GitlabCi;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use OndraM\CiDetector\Ci\CiInterface;
use OndraM\CiDetector\CiDetector;
use Psr\Container\ContainerInterface;

class RequestFetcher
{
    protected array $ciMap = [
        CiDetector::CI_GITLAB => GitlabCi::class,
    ];

    public function __construct(protected ContainerInterface $container)
    {
        //
    }

    public function fetch(CiInterface $ci): MergeRequest
    {
        if (! array_key_exists($ci->getCiName(), $this->ciMap)) {
            throw new CiNotSupported();
        }

        return $this->container->get($this->ciMap[$ci->getCiName()])->getMergeRequest();
    }
}
