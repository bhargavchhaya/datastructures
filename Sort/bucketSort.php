<?php
// Bucket Sort function
function bucketSort(&$array) {
    // Find the maximum and minimum values in the array
    $max = max($array);
    $min = min($array);

    // Determine the number of buckets based on the range of the numbers
    $bucketCount = floor($max - $min) + 1;
    $buckets = array_fill(0, $bucketCount, []);

    // Distribute elements into buckets
    foreach ($array as $num) {
        $index = floor(($num - $min) / ($max - $min + 1) * ($bucketCount - 1));
        $buckets[$index][] = $num;
    }

    // Sort each bucket using a simple sorting algorithm (e.g., insertion sort)
    foreach ($buckets as &$bucket) {
        sort($bucket);
    }

    // Concatenate the sorted buckets into the original array
    $array = [];
    foreach ($buckets as $bucket) {
        foreach ($bucket as $num) {
            $array[] = $num;
        }
    }
}

// Example array
$array = [0.42, 0.32, 0.23, 0.54, 0.37, 0.87, 0.91, 0.78];
echo "Unsorted array: ";
print_r($array);

// Call the bucket sort function
bucketSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
