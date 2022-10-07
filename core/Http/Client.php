<?php

namespace Core\Http;

class Client
{
  /**
   * Fetches data trough GET method in a given endpoint.
   *
   * @param string $url Target URL.
   * @param array $params The get params.
   * @return array The request result.
   */
  public function get(string $url, array $params = [])
  {
    $ch = curl_init();

    curl_setopt_array($ch, [
      CURLOPT_HTTPGET => true,
      CURLOPT_URL => $url . '?' . http_build_query($params)
    ]);

    return $this->send($ch);
  }

  /**
   * Sends a request to a given endpoint.
   *
   * @param $ch The CURL handle.
   * @return array The request result.
   */
  private function send($ch): array
  {
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
  }
}