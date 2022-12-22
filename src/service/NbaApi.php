<?php
//namespace App\service;
//use Symfony\Contracts\HttpClient\HttpClientInterface;
//
//class NbaApi
//{
//    private string $nbaApi = "https://api-nba-v1.p.rapidapi.com/";
//
//    public function __construct(
//        private HttpClientInterface $httpClient
//    )
//    {
//    }
//
//    /**
//     * @return array
//     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
//     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
//     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
//     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
//     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
//     */
//
//    public function getAllmatch(): array{
//        $response = $this->httpClient->request('GET', $this->nbaApi . 'matchs', );
//        return $response->toArray();
//    }
//
//}