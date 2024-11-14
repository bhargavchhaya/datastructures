<?php
// Pigeonhole Sort function
function pigeonholeSort(&$array) {
    // Find the minimum and maximum values in the array
    $min = min($array);
    $max = max($array);
    
    // Create pigeonholes (bins) based on the range of values
    $range = $max - $min + 1;
    $pigeonholes = array_fill(0, $range, 0);
    
    // Place elements in corresponding pigeonholes
    foreach ($array as $num) {
        $pigeonholes[$num - $min]++;
    }

    // Reconstruct the sorted array
    $index = 0;
    foreach ($pigeonholes as $value => $count) {
        for ($i = 0; $i < $count; $i++) {
            $array[$index++] = $value + $min;
        }
    }
}

// Example array
$array = [8, 3, 2, 7, 4, 6, 8, 9, 5, 6];
echo "Unsorted array: ";
print_r($array);

// Call the pigeonhole sort function
pigeonholeSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
