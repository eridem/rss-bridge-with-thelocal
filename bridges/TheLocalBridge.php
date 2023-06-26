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
                'Sweden' => 'sweden',
                'Switzerland' => 'switzerland'
            ]
        ]
    ]];

    public function collectData()
    {
        $dom = getSimpleHTMLDOM('https://thelocal.com');
        foreach ($dom->find('.blog-posts li') as $li) {
            $a = $li->find('a', 0);
            $this->items[] = [
                'title' => $a->plaintext,
                'uri' => 'https://thelocal.com' . $a->href,
            ];
        }
    }
}
