<?php
// Linear search function
function linearSearch($array, $target) {
    // Iterate through the array
    for ($i = 0; $i < count($array); $i++) {
        // Check if the current element is the target
        if ($array[$i] == $target) {
            return $i; // Return the index if the target is found
        }
    }
    return false; // Return false if the target is not found
}

// Example array
$array = [10, 20, 30, 40, 50];

// Example target value
$target = 30;

// Call the linear search function
$result = linearSearch($array, $target);

// Output the result
if ($result !== false) {
    echo "Target found at index: " . $result;
} else {
    echo "Target not found in the array.";
}