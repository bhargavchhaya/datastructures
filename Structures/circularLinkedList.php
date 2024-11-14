<?php

// Node class to represent each element in the circular linked list
class Node {
    public $data;
    public $next;

    public function __construct($data) {
        $this->data = $data;
        $this->next = null;
    }
}

// CircularLinkedList class to manage the circular linked list
class CircularLinkedList {
    private $head;

    public function __construct() {
        $this->head = null;
    }

    // Insert a node at the beginning of the list
    public function insertAtBeginning($data) {
        $newNode = new Node($data);
        
        if ($this->head === null) {
            $this->head = $newNode;
            $newNode->next = $this->head;
        } else {
            $current = $this->head;
            while ($current->next !== $this->head) {
                $current = $current->next;
            }
            $newNode->next = $this->head;
            $this->head = $newNode;
            $current->next = $this->head;
        }
        echo "Inserted $data at the beginning\n";
    }

    // Insert a node at the end of the list
    public function insertAtEnd($data) {
        $newNode = new Node($data);
        
        if ($this->head === null) {
            $this->head = $newNode;
            $newNode->next = $this->head;
        } else {
            $current = $this->head;
            while ($current->next !== $this->head) {
                $current = $current->next;
            }
            $current->next = $newNode;
            $newNode->next = $this->head;
        }
        echo "Inserted $data at the end\n";
    }

    // Insert a node at a specific position
    public function insertAtPosition($data, $position) {
        $newNode = new Node($data);

        if ($position <= 0) {
            echo "Position should be greater than 0\n";
            return;
        }

        if ($position === 1) {
            $this->insertAtBeginning($data);
            return;
        }

        $current = $this->head;
        $count = 1;

        while ($count < $position - 1 && $current->next !== $this->head) {
            $current = $current->next;
            $count++;
        }

        if ($count < $position - 1) {
            echo "Position out of bounds. Adding at the end instead.\n";
            $this->insertAtEnd($data);
        } else {
            $newNode->next = $current->next;
            $current->next = $newNode;
            echo "Inserted $data at position $position\n";
        }
    }

    // Delete a node by value
    public function deleteNode($data) {
        if ($this->head === null) {
            echo "List is empty. Cannot delete $data\n";
            return;
        }

        $current = $this->head;
        $prev = null;

        // If the node to be deleted is the head node
        if ($current->data === $data) {
            // If there's only one node in the list
            if ($current->next === $this->head) {
                $this->head = null;
            } else {
                while ($current->next !== $this->head) {
                    $current = $current->next;
                }
                $this->head = $this->head->next;
                $current->next = $this->head;
            }
            echo "Deleted $data from the list\n";
            return;
        }

        $prev = $current;
        $current = $current->next;

        // Traverse the list to find the node to delete
        while ($current !== $this->head && $current->data !== $data) {
            $prev = $current;
            $current = $current->next;
        }

        if ($current === $this->head) {
            echo "$data not found in the list\n";
        } else {
            $prev->next = $current->next;
            echo "Deleted $data from the list\n";
        }
    }

    // Display the list
    public function display() {
        if ($this->head === null) {
            echo "List is empty\n";
            return;
        }

        echo "Circular Linked List: ";
        $current = $this->head;
        do {
            echo $current->data . " -> ";
            $current = $current->next;
        } while ($current !== $this->head);
        echo "(head)\n";
    }
}

// Example usage
$circularList = new CircularLinkedList();

$circularList->insertAtEnd(10);
$circularList->insertAtEnd(20);
$circularList->insertAtBeginning(5);
$circularList->insertAtEnd(30);
$circularList->display();

$circularList->insertAtPosition(25, 3); // Insert 25 at position 3
$circularList->display();

$circularList->deleteNode(20);
$circularList->display();

$circularList->deleteNode(40); // Attempt to delete non-existent node
$circularList->display();
?>
