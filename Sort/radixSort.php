<?php
// Radix Sort function
function radixSort(&$array) {
    // Find the maximum number to know the number of digits
    $max = max($array);
    
    // Perform counting sort for every digit. The place value starts at 1 (units place)
    for ($place = 1; $max / $place > 0; $place *= 10) {
        countingSortByDigit($array, $place);
    }
}

// Counting Sort function to sort the array based on the digit represented by 'place'
function countingSortByDigit(&$array, $place) {
    $n = count($array);
    $output = array_fill(0, $n, 0);  // Output array to store sorted elements
    $count = array_fill(0, 10, 0);   // Count array to store frequency of digits (0-9)
    
    // Count occurrences of each digit (digit at 'place' value)
    foreach ($array as $num) {
        $digit = floor($num / $place) % 10;
        $count[$digit]++;
    }
    
    // Change count[i] to contain the actual position of this digit in output[]
    for ($i = 1; $i < 10; $i++) {
        $count[$i] += $count[$i - 1];
    }
    
    // Build the output array by placing the elements in their correct position
    for ($i = $n - 1; $i >= 0; $i--) {
        $digit = floor($array[$i] / $place) % 10;
        $output[$count[$digit] - 1] = $array[$i];
        $count[$digit]--;
    }
    
    // Copy the sorted numbers into the original array
    for ($i = 0; $i < $n; $i++) {
        $array[$i] = $output[$i];
    }
}

// Example array
$array = [170, 45, 75, 90, 802, 24, 2, 66];
echo "Unsorted array: ";
print_r($array);

// Call the radix sort function
radixSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
