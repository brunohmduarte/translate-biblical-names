<?php

if (isset($_GET['txtSearch']) && !empty($_GET['txtSearch'])) {

    define(BIBLICAL_NAMES_FILE_PATH, 'mock/names.csv');

    /**
     * Retrieve all names in repository.
     *
     * @return array|string
     */
    function getBibleNames() {
        $data = [];
        try {
            $handle = fopen(BIBLICAL_NAMES_FILE_PATH, 'r');
            if ($handle !== false) {
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $reference = explode(' - ', $row[2]);
                    array_push($data, [
                        'name' => strtolower($row[0]),
                        'origin' => strtolower($row[1]),
                        'translate' => strtolower($reference[0]),
                        'reference' => $reference[1]
                    ]);
                }

                fclose($handle);
                return $data;
            }

            fclose($handle);
            throw new Exception("Could not read the file.");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Perform research
     * @param $repository
     * @param $name
     * @return mixed|void
     */
    function doSearch($repository, $name) {
        if (!is_string($name) || empty($name) || empty($repository)) {
            return;
        }

        $keySelected = array_search($name, array_column($repository, 'name'), false);
        return $repository[$keySelected];
    }

    /**
     * Shows the only search result.
     * @param $search
     * @return void
     */
    function showOnlyResult($search) {
        $names = getBibleNames();
        if (empty($names)) {
            return;
        }
        return doSearch($names, $search);
    }

    /**
     * Show translation of multiple search terms
     * @param $search
     * @return array
     */
    function showMultipleResults($search) {
        $search = preg_replace('/\s/', '', $search);
        $terms = explode(',', $search);
        list($translate, $phrase) = [[],''];
        $translate['data'] = [];
        foreach($terms as $term) {
            $transTerm = showOnlyResult($term);
            array_push($translate['data'], $transTerm);

            $phrase .= "{$transTerm['translate']} ";
        }

        $translate['phrase'] = $phrase;

        return $translate;
    }

    $search = strtolower(filter_var($_GET['txtSearch'], FILTER_SANITIZE_STRING));
    if (strpos($search, ',') !== false) {
        $result = showMultipleResults($search);
    } else {
        $result['data'][] = showOnlyResult($search);
    }

    if (empty($result)) {
        header('Location: index.php?error=Não foi possivél encontrar a tradução.');
        exit;
    }

    $json = base64_encode(json_encode($result));
    header('Location: index.php?result='.$json);
}