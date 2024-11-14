<?php
// Insertion sort function
function insertionSort(&$array) {
    $n = count($array);
    
    // Traverse through all elements in the array starting from the second element
    for ($i = 1; $i < $n; $i++) {
        // Store the current element to be inserted in the sorted part
        $key = $array[$i];
        
        // Move elements of the sorted part that are greater than the key, one position ahead
        $j = $i - 1;
        
        // Shift elements that are greater than $key to one position ahead
        while ($j >= 0 && $array[$j] > $key) {
            $array[$j + 1] = $array[$j];
            $j--;
        }
        
        // Place the key in the correct position
        $array[$j + 1] = $key;
    }
}

// Example array
$array = [12, 11, 13, 5, 6];
echo "Unsorted array: ";
print_r($array);

// Call the insertion sort function
insertionSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
