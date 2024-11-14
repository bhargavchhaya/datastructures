<?php
// Selection sort function
function selectionSort(&$array) {
    $n = count($array);
    
    // Traverse through all elements of the array
    for ($i = 0; $i < $n - 1; $i++) {
        // Find the minimum element in the unsorted part of the array
        $minIndex = $i;
        
        for ($j = $i + 1; $j < $n; $j++) {
            if ($array[$j] < $array[$minIndex]) {
                $minIndex = $j;
            }
        }
        
        // Swap the found minimum element with the first element of the unsorted part
        if ($minIndex != $i) {
            $temp = $array[$i];
            $array[$i] = $array[$minIndex];
            $array[$minIndex] = $temp;
        }
    }
}

// Example array
$array = [64, 25, 12, 22, 11];
echo "Unsorted array: ";
print_r($array);

// Call the selection sort function
selectionSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
