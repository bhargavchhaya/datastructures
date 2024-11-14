<?php
// Counting Sort function
function countingSort(&$array) {
    // Find the maximum and minimum values in the array
    $max = max($array);
    $min = min($array);

    // Create a count array to store the frequency of each element
    $count = array_fill(0, $max - $min + 1, 0);
    
    // Count the frequency of each element in the input array
    foreach ($array as $num) {
        $count[$num - $min]++;
    }

    // Reconstruct the sorted array
    $index = 0;
    for ($i = 0; $i < count($count); $i++) {
        while ($count[$i] > 0) {
            $array[$index++] = $i + $min;  // Rebuild the array with the correct sorted values
            $count[$i]--;
        }
    }
}

// Example array
$array = [4, 2, 2, 8, 3, 3, 1, 5, 6, 4, 2];
echo "Unsorted array: ";
print_r($array);

// Call the counting sort function
countingSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
