<?php


namespace Jimi\Frontend;

use Phalcon\Mvc\Controller;
use Jimi\Models\Posts;
use Phalcon\Http\Response;

/**
 * Class SitemapController
 *
 * @package Jimi\Controllers
 */
class SitemapController extends ControllerBase
{

    public function initialize()
    {
        $this->view->disable();
    }

    /**
     * Generate the website sitemap
     *
     */
    public function indexAction()
    {

        $response = new Response();

        $expireDate = new \DateTime();
        $expireDate->modify('+1 day');

        $response->setExpires($expireDate);

        $response->setHeader('Content-Type', "application/xml; charset=UTF-8");

        $sitemap = new \DOMDocument("1.0", "UTF-8");

        $urlset = $sitemap->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        $url = $sitemap->createElement('url');
        $url->appendChild($sitemap->createElement('loc', 'http://forum.phalconphp.com/'));
        $url->appendChild($sitemap->createElement('changefreq', 'daily'));
        $url->appendChild($sitemap->createElement('priority', '1.0'));
        $urlset->appendChild($url);

        $parametersPosts = array(
            'conditions' => 'deleted != 1',
            'columns'    => 'id, slug, modified_at, number_views + ((IF(votes_up IS NOT NULL, votes_up, 0) - IF(votes_down IS NOT NULL, votes_down, 0)) * 4) + number_replies AS karma',
            'order'      => 'karma DESC'
        );
        $posts = Posts::find($parametersPosts);

        $parametersKarma = array(
            'column' => 'number_views + ((IF(votes_up IS NOT NULL, votes_up, 0) - IF(votes_down IS NOT NULL, votes_down, 0)) * 4) + number_replies',
            'conditions' => 'deleted != 1'
        );
        $karma = Posts::maximum($parametersKarma);

        $modifiedAt = new \DateTime();
        $modifiedAt->setTimezone(new \DateTimeZone('UTC'));

        $baseUrl = $this->config->site->url;
        foreach ($posts as $post) {

            $modifiedAt->setTimestamp($post->modified_at);

            $postKarma = $post->karma / ($karma + 100);

            $url = $sitemap->createElement('url');
            $href = $baseUrl . '/discussion/' . $post->id . '/' . $post->slug;
            $url->appendChild(
                $sitemap->createElement('loc', $href)
            );

            $valuePriority = $postKarma > 0.7 ? sprintf("%0.1f", $postKarma) : sprintf("%0.1f", $postKarma + 0.25);
            $url->appendChild(
                $sitemap->createElement('priority', $valuePriority)
            );
            $url->appendChild($sitemap->createElement('lastmod', $modifiedAt->format('Y-m-d\TH:i:s\Z')));
            $urlset->appendChild($url);
        }

        $sitemap->appendChild($urlset);

        $response->setContent($sitemap->saveXML());
        return $response;
    }
}