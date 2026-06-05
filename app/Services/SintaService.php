<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class SintaService
{
    public function getProfile($sintaId)
    {
        $url = "https://sinta.kemdiktisaintek.go.id/authors/profile/" . $sintaId;

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0'
        ]);

        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return [
                'success' => false,
                'message' => 'Gagal mengambil data SINTA'
            ];
        }

        return $this->parseProfile($html);
    }

    private function parseProfile($html)
    {
        $crawler = new Crawler($html);

        $name = trim(
            $crawler->filter('h3 a')->first()->text()
        );

        $meta = $crawler->filter('.meta-profile a');

        $scores = [];

        $crawler->filter('.pr-num')->each(function ($node) use (&$scores) {
            $scores[] = trim($node->text());
        });

        $stats = [];

        $crawler->filter('.stat-table tbody tr')
            ->each(function ($tr) use (&$stats) {

                $td = $tr->filter('td');

                if ($td->count() >= 3) {

                    $key = trim($td->eq(0)->text());

                    $stats[$key] = [
                        'scopus' => trim($td->eq(1)->text()),
                        'google' => trim($td->eq(2)->text())
                    ];
                }
            });

        return [
            'success' => true,

            'nama' => $name,

            'affiliation' =>
            $meta->count() > 0
                ? trim($meta->eq(0)->text())
                : '',

            'department' =>
            $meta->count() > 1
                ? trim($meta->eq(1)->text())
                : '',

            'sinta_id' =>
            $meta->count() > 2
                ? preg_replace('/[^0-9]/', '', $meta->eq(2)->text())
                : '',

            'sinta_score_overall' => $scores[0] ?? 0,
            'sinta_score_3yr'     => $scores[1] ?? 0,
            'affil_score'         => $scores[2] ?? 0,
            'affil_score_3yr'     => $scores[3] ?? 0,

            'article_scopus' =>
            $stats['Article']['scopus'] ?? 0,

            'article_google' =>
            $stats['Article']['google'] ?? 0,

            'citation_scopus' =>
            $stats['Citation']['scopus'] ?? 0,

            'citation_google' =>
            $stats['Citation']['google'] ?? 0,

            'hindex_scopus' =>
            $stats['H-Index']['scopus'] ?? 0,

            'hindex_google' =>
            $stats['H-Index']['google'] ?? 0,

            'i10_scopus' =>
            $stats['i10-Index']['scopus'] ?? 0,

            'i10_google' =>
            $stats['i10-Index']['google'] ?? 0,
        ];
    }
}
