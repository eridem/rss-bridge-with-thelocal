<?php

class TheLocalBridge extends BridgeAbstract
{
    const NAME = 'TheLocal (thelocal.com)';
    const DESCRIPTION = 'Get full text news from thelocal.com';
    const PARAMETERS = [ [
        'zone' => [
            'name' => 'Zone',
            'type' => 'list',
            'values' => [
                'Europe' => 'europe',
                'Austria' => 'austria',
                'Denmark' => 'denmark',
                'France' => 'france',
                'Germany' => 'germany',
                'Italy' => 'italy',
                'Norway' => 'norway',
                'Spain' => 'spain',
                'Sweden' => 'se',
                'Switzerland' => 'switzerland'
            ]
        ]
    ]];

    public function collectData()
    {
        $feed_html_headers = [
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:109.0) Gecko/20100101 Firefox/114.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: gzip, deflate, br',
            'DNT: 1',
            'Alt-Used: www.thelocal.se',
            'Connection: keep-alive',
            'Cookie: __pil=en_US',
            'Upgrade-Insecure-Requests: 1',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: cross-site',
            'Sec-GPC: 1',
            'Pragma: no-cache',
            'Cache-Control: no-cache'
        ];

        $feed_url = "https://feeds.thelocal.com/rss/" . $this->getInput('zone');
        $feed_xml = getSimpleHTMLDOM($feed_url);
        $feed_items = $feed_xml->find('item');

        foreach ($feed_items as $item) {
            $title = $item->find('title', 0)->plaintext;
            $link = $item->find('link', 0)->plaintext;

            $feed_html = getSimpleHTMLDOM($link, $feed_html_headers);

            $content = $feed_html->find('.article-single__content');

            $this->items[] = [
                'title' => $title,
                'content' => "---",
            ];
        }   
    }
}
