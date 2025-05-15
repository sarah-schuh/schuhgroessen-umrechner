<?php

// Path to the CSV file
$csvFile = 'data/shoe_sizes.csv';

// Internationalization strings
$messages = [
    'no_match' => 'No matching shoe size found for EU size: ',
    'provide_eu_size' => 'Please provide an EU shoe size using the "eu_size" query parameter.',
    'invalid_input' => 'Invalid input. Please provide a numeric EU shoe size.',
    'file_error' => 'Error: CSV file is not accessible or readable.'
];

// Check if the CSV file exists and is readable
if (!file_exists($csvFile) || !is_readable($csvFile)) {
    die($messages['file_error']);
}

/**
 * Read CSV file and return data as an associative array
 *
 * @param string $filename
 * @return array
 */
function readCsv($filename) {
    $rows = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle, 1000, ',');
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $rows[] = array_combine($header, $data);
        }
        fclose($handle);
    }
    return $rows;
}

/**
 * Find shoe size conversions based on EU size
 *
 * @param float|string $euSize
 * @param array $sizes
 * @return array|null
 */
function findShoeSize($euSize, $sizes) {
    foreach ($sizes as $size) {
        if ($size['EU'] == $euSize) {
            return $size;
        }
    }
    return null;
}

/**
 * Convert centimeters to inches
 *
 * @param float $cm
 * @return float
 */
function cmToInch($cm) {
    return $cm / 2.54;
}

// Retrieve and validate the EU shoe size from query parameter
$euSize = filter_input(INPUT_GET, 'eu_size', FILTER_VALIDATE_FLOAT);

if ($euSize === false || $euSize === null) {
    echo $messages['invalid_input'];
    exit;
}

// Read shoe sizes data from CSV file
$shoeSizes = readCsv($csvFile);

// Find the corresponding shoe sizes
$result = findShoeSize($euSize, $shoeSizes);

if ($result) {
    // Output formatted shoe sizes
    echo "EU Size: " . htmlspecialchars($result['EU']) . "<br>";
    echo "US Size: " . htmlspecialchars($result['US']) . "<br>";
    echo "UK Size: " . htmlspecialchars($result['UK']) . "<br>";
    echo "Size in CM: " . htmlspecialchars($result['CM']) . " cm<br>";
    echo "Size in Inches: " . number_format(cmToInch($result['CM']), 2) . " in<br>";
} else {
    echo $messages['no_match'] . htmlspecialchars($euSize);
}
?>
