<?php
// Path to the CSV file
$csvFile = 'data/shoe_sizes.csv';

// Internationalization strings
$messages = [
    'no_match' => 'No matching shoe size found for EU size: ',
    'provide_eu_size' => 'Please provide an EU shoe size using the 'eu_size' query parameter.'
];

// Function to read CSV file and return data as an associative array
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

// Function to find shoe size conversions
function findShoeSize($euSize, $sizes) {
    foreach ($sizes as $size) {
        if ($size['EU'] == $euSize) {
            return $size;
        }
    }
    return null;
}

// Function to convert cm to inches
function cmToInch($cm) {
    return $cm / 2.54;
}

// Read the shoe sizes from the CSV file
$shoeSizes = readCsv($csvFile);

// Get the EU shoe size from the query parameter
$euSize = isset($_GET['eu_size']) ? $_GET['eu_size'] : null;

if ($euSize !== null) {
    // Find the corresponding shoe sizes
    $result = findShoeSize($euSize, $shoeSizes);
    
    if ($result) {
        echo "EU Size: " . $result['EU'] . "<br>";
        echo "US Size: " . $result['US'] . "<br>";
        echo "UK Size: " . $result['UK'] . "<br>";
        echo "Size in CM: " . $result['CM'] . "<br>";
        echo "Size in Inches: " . cmToInch($result['CM']) . "<br>";
    } else {
        echo $messages['no_match'] . $euSize;
    }
} else {
    echo $messages['provide_eu_size'];
}
?>
