<?php
// Heap Sort function
function heapSort(&$array) {
    $n = count($array);
    
    // Build a max heap (convert the array into a max heap)
    for ($i = floor($n / 2) - 1; $i >= 0; $i--) {
        heapify($array, $n, $i);
    }
    
    // Extract elements from the heap one by one
    for ($i = $n - 1; $i > 0; $i--) {
        // Swap the current root (max element) with the last element
        swap($array, 0, $i);
        
        // Call heapify on the reduced heap
        heapify($array, $i, 0);
    }
}

// Heapify function to maintain the heap property
function heapify(&$array, $n, $i) {
    $largest = $i;
    $left = 2 * $i + 1;
    $right = 2 * $i + 2;
    
    // If left child is larger than root
    if ($left < $n && $array[$left] > $array[$largest]) {
        $largest = $left;
    }
    
    // If right child is larger than largest so far
    if ($right < $n && $array[$right] > $array[$largest]) {
        $largest = $right;
    }
    
    // If largest is not root
    if ($largest != $i) {
        swap($array, $i, $largest);
        
        // Recursively heapify the affected sub-tree
        heapify($array, $n, $largest);
    }
}

// Swap two elements in the array
function swap(&$array, $i, $j) {
    $temp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $temp;
}

// Example array
$array = [12, 11, 13, 5, 6, 7];
echo "Unsorted array: ";
print_r($array);

// Call the heap sort function
heapSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
