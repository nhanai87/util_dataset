<?php

namespace go1\util_dataset\staff\es_dumper;

use Elasticsearch\Client;
use go1\util\es\Schema;
use go1\util_es\Scroll;

/**
 * GET #staff/devel/php
 *
 * echo \go1\util_dataset\staff\es_dumper\ElasticSearchAccountDumper::dump($app['go1.client.es'], 500592);
 */
class ElasticSearchAccountDumper
{
    public static function dump(Client $client, int $portalId)
    {
        $_ = Scroll::scroll($client, [
            'index' => Schema::portalIndex($portalId),
            'type'  => Schema::O_ACCOUNT,
        ]);

        foreach ($_ as $row) {
            $user = &$row['_source'];
            $users[$user['id']] = $user;
        }

        return json_encode(array_values($users ?? []));
    }
}
