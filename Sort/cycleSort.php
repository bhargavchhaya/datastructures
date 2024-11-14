<?php
// Cycle Sort function
function cycleSort(&$array) {
    $n = count($array);
    
    // One by one move elements to their correct position
    for ($cycleStart = 0; $cycleStart < $n - 1; $cycleStart++) {
        $item = $array[$cycleStart];
        
        // Find the index where we put the current element
        $pos = $cycleStart;
        for ($i = $cycleStart + 1; $i < $n; $i++) {
            if ($array[$i] < $item) {
                $pos++;
            }
        }

        // If the element is already in the correct position, skip it
        if ($pos == $cycleStart) {
            continue;
        }

        // Otherwise, put the element to the correct position
        while ($item == $array[$pos]) {
            $pos++;
        }
        
        // Swap the element to the correct position
        $temp = $array[$pos];
        $array[$pos] = $item;
        $item = $temp;

        // Rotate the cycle
        while ($pos != $cycleStart) {
            $pos = $cycleStart;
            for ($i = $cycleStart + 1; $i < $n; $i++) {
                if ($array[$i] < $item) {
                    $pos++;
                }
            }

            // Put the element to its correct position
            while ($item == $array[$pos]) {
                $pos++;
            }

            // Swap the element to the correct position
            $temp = $array[$pos];
            $array[$pos] = $item;
            $item = $temp;
        }
    }
}

// Example array
$array = [5, 2, 9, 1, 5, 6];
echo "Unsorted array: ";
print_r($array);

// Call the cycle sort function
cycleSort($array);

// Output the sorted array
echo "Sorted array: ";
print_r($array);
?>
