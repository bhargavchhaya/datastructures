<?php
// Bubble sort function
function bubbleSort(&$array) {
    $n = count($array);
    
    // Traverse through all elements in the array
    for ($i = 0; $i < $n - 1; $i++) {
        // Flag to check if any swaps were made in this pass
        $swapped = false;
        
        // Compare adjacent elements and swap if necessary
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($array[$j] > $array[$j + 1]) {
                // Swap the elements
                $temp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $temp;
                
                // Set flag to true indicating a swap was made
                $swapped = true;
            }
        }
        
        // If no elements were swapped, the array is sorted
        if (!$swapped) {
            break;
        }
    }
}

// Example array
$array = [64, 34, 25, 12, 22, 11, 90];
echo "Unsorted array: ";
print_r($array);

// Call the bubble sort function
bubbleSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
