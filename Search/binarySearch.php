<?php
// Binary search function
function binarySearch($array, $target) {
    $low = 0; // starting index
    $high = count($array) - 1; // ending index
    
    while ($low <= $high) {
        // Find the middle element
        $mid = floor(($low + $high) / 2);
        
        // Check if the target is at the middle
        if ($array[$mid] == $target) {
            return $mid; // Target found, return the index
        }
        
        // If target is smaller than middle element, search left half
        if ($array[$mid] > $target) {
            $high = $mid - 1;
        }
        // If target is greater than middle element, search right half
        else {
            $low = $mid + 1;
        }
    }
    
    return false; // Return false if target is not found
}

// Example sorted array
$array = [1, 3, 5, 7, 9, 11, 13, 15, 17, 19];

// Example target value
$target = 7;

// Call the binary search function
$result = binarySearch($array, $target);

// Output the result
if ($result !== false) {
    echo "Target found at index: " . $result;
} else {
    echo "Target not found in the array.";
}