<?php
// Merge Sort function
function mergeSort($array) {
    // Base case: If the array has one or zero elements, it's already sorted
    if (count($array) <= 1) {
        return $array;
    }
    
    // Find the middle index
    $mid = floor(count($array) / 2);
    
    // Split the array into two halves
    $left = array_slice($array, 0, $mid);
    $right = array_slice($array, $mid);
    
    // Recursively sort both halves
    $left = mergeSort($left);
    $right = mergeSort($right);
    
    // Merge the sorted halves and return the result
    return merge($left, $right);
}

// Merge function to merge two sorted arrays
function merge($left, $right) {
    $result = [];
    $leftIndex = $rightIndex = 0;
    
    // Merge the two arrays by comparing elements
    while ($leftIndex < count($left) && $rightIndex < count($right)) {
        if ($left[$leftIndex] < $right[$rightIndex]) {
            $result[] = $left[$leftIndex];
            $leftIndex++;
        } else {
            $result[] = $right[$rightIndex];
            $rightIndex++;
        }
    }
    
    // Append any remaining elements from the left array
    while ($leftIndex < count($left)) {
        $result[] = $left[$leftIndex];
        $leftIndex++;
    }
    
    // Append any remaining elements from the right array
    while ($rightIndex < count($right)) {
        $result[] = $right[$rightIndex];
        $rightIndex++;
    }
    
    return $result;
}

// Example array
$array = [38, 27, 43, 3, 9, 82, 10];
echo "Unsorted array: ";
print_r($array);

// Call the merge sort function
$sortedArray = mergeSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($sortedArray);
?>
