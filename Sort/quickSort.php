<?php
// Quick Sort function
function quickSort(&$array) {
    // Base case: if the array has one or zero elements, it's already sorted
    if (count($array) <= 1) {
        return $array;
    }

    // Select a pivot element (Here, we choose the last element as the pivot)
    $pivot = $array[count($array) - 1];
    
    // Arrays to hold elements less than and greater than the pivot
    $left = $right = [];
    
    // Partition the array into left and right sub-arrays based on the pivot
    for ($i = 0; $i < count($array) - 1; $i++) {
        if ($array[$i] < $pivot) {
            $left[] = $array[$i]; // Elements less than pivot
        } else {
            $right[] = $array[$i]; // Elements greater than or equal to pivot
        }
    }
    
    // Recursively sort the left and right sub-arrays
    $left = quickSort($left);
    $right = quickSort($right);
    
    // Merge the sorted sub-arrays and pivot into a single sorted array
    return array_merge($left, [$pivot], $right);
}

// Example array
$array = [10, 7, 8, 9, 1, 5];
echo "Unsorted array: ";
print_r($array);

// Call the quick sort function
$sortedArray = quickSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($sortedArray);
?>
