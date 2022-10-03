<?php
/**
 * Author: Aissa BELKAID
 * CreateDate: 02/10/2022
 * Description: Google search crawler engine.
 */

include ("simple_html_dom.php"); // Simple and reliable HTML document parser for PHP

$GLOBALS = array(
    'Domain' => 'google.ae' // The default google domain is 'ae'
);

class SearchEngine
{

    /**
     * Get the results: keyword,ranking,url,title,description,promoted
     * @param array $keywords
     * @param string $language
     * @param int $num
     * @return ArrayIterator
     */
    function search($keywords = [], $language = 'en', $num = '53')
    {
        $keywords = new ArrayIterator($keywords);
        foreach ($keywords as $keyword) {
        $keyword = trim($keyword);
        $data = $this->search_initializer($keyword, $language, $num);
        $html = new simple_html_dom();
        $html->load(utf8_encode($data));
        $rank = 0;

        // Get the promoted results
        foreach ($html->find('div[class="Gx5Zad fP1Qef EtOod pkphOe"]') as $element)
            yield [
                'keyword' => $keyword,
                'ranking' => $rank++,
                'url' => $this->filter_href($element->find('span[class="qzEoUe"]', 0)->plaintext),
                'title' => $element->find('div[class="CCgQ5 MUxGbd v0nnCb aLF0Z OSrXXb"]>span', 0)->plaintext,
                'description' => $element->find('div[class="MUxGbd yDYNvb lyLwlc"]>div', 0)->plaintext,
                'promoted' => 1
            ];

        // Get the organic results 
        foreach ($html->find('div[class="Gx5Zad fP1Qef xpd EtOod pkphOe"]') as $element)
            yield [
                'keyword' => $keyword,
                'ranking' => $rank++,
                'url' => $this->filter_href($element->find('div[class="egMi0 kCrYT"]>a', 0)->href),
                'title' => $element->find('h3', 0)->plaintext,
                'description' => $element->find('div[class="BNeawe s3v9rd AP7Wnd"]', 0)->plaintext,
                'promoted' => 0
            ];
        }
    }

    /**
     * Initialize the parameters of search
     *
     * @param $keyword
     * @param string $language
     * @param int $num
     * @return DOM $data
     */
    function search_initializer($keyword, $language, $num)
    {
        $keyword = urlencode($keyword);
        if (empty($num)) {
            $url = sprintf('%s/search?charset=utf8&hl=%s&output=search&q=%s', $GLOBALS['Domain'], $language, $keyword);
        } else {
            $url = sprintf('%s/search?charset=utf8&hl=%s&output=search&q=%s&num=%s', $GLOBALS['Domain'], $language, $keyword, $num);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // To search inside the land of the UAE 
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_REFERER, $url);

            $data = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $data = '';
            echo $e->getMessage();
        }

        return $data;
    }

    /**
     * Set the Domain global variable to a specific domain
     * @param $engine
     * @return string $domain
     */
    function setEngine($engine)
    {
        $GLOBALS['Domain']  = 'https://www.' . $engine;
    }

    /**
     * Returns None if the link doesn't yield a valid result
     * @param $href
     * @return string
     */
    function filter_href($href)
    {
        if (!empty($href)) {
            try {
                $o = parse_url($href);
                if (strpos($href, "/url?") === 0) {
                    parse_str($o['query'], $link);
                    $href = $link['q'];
                    return $href;
                }
            } catch (Exception $e) {
                $href = '';
                echo $e->getMessage();
            }
        }
        return $href;
    }

}