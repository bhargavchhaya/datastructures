<?php

// Node class to represent each node in the Binary Search Tree
class Node {
    public $data;
    public $left;
    public $right;

    public function __construct($data) {
        $this->data = $data;
        $this->left = null;
        $this->right = null;
    }
}

// BinarySearchTree class to manage the binary search tree
class BinarySearchTree {
    private $root;

    public function __construct() {
        $this->root = null;
    }

    // Insert a node into the BST
    public function insert($data) {
        $this->root = $this->insertRec($this->root, $data);
        echo "Inserted $data into the tree\n";
    }

    // Helper function for inserting nodes (recursively)
    private function insertRec($node, $data) {
        if ($node === null) {
            return new Node($data);
        }

        if ($data < $node->data) {
            $node->left = $this->insertRec($node->left, $data);
        } else {
            $node->right = $this->insertRec($node->right, $data);
        }

        return $node;
    }

    // Search for a node with a specific value
    public function search($data) {
        $foundNode = $this->searchRec($this->root, $data);
        return $foundNode ? $foundNode : null;
    }

    // Helper function for searching (recursively)
    private function searchRec($node, $data) {
        if ($node === null || $node->data === $data) {
            return $node;
        }

        if ($data < $node->data) {
            return $this->searchRec($node->left, $data);
        } else {
            return $this->searchRec($node->right, $data);
        }
    }

    // In-order traversal (left, root, right)
    public function inOrder() {
        echo "In-order traversal: ";
        $this->inOrderRec($this->root);
        echo "\n";
    }

    // Helper function for in-order traversal (recursively)
    private function inOrderRec($node) {
        if ($node !== null) {
            $this->inOrderRec($node->left);
            echo $node->data . " ";
            $this->inOrderRec($node->right);
        }
    }

    // Pre-order traversal (root, left, right)
    public function preOrder() {
        echo "Pre-order traversal: ";
        $this->preOrderRec($this->root);
        echo "\n";
    }

    // Helper function for pre-order traversal (recursively)
    private function preOrderRec($node) {
        if ($node !== null) {
            echo $node->data . " ";
            $this->preOrderRec($node->left);
            $this->preOrderRec($node->right);
        }
    }

    // Post-order traversal (left, right, root)
    public function postOrder() {
        echo "Post-order traversal: ";
        $this->postOrderRec($this->root);
        echo "\n";
    }

    // Helper function for post-order traversal (recursively)
    private function postOrderRec($node) {
        if ($node !== null) {
            $this->postOrderRec($node->left);
            $this->postOrderRec($node->right);
            echo $node->data . " ";
        }
    }

    // Delete a node by value
    public function delete($data) {
        $this->root = $this->deleteRec($this->root, $data);
        echo "Deleted $data from the tree\n";
    }

    // Helper function for deleting a node (recursively)
    private function deleteRec($node, $data) {
        if ($node === null) {
            return null;
        }

        // If the data to be deleted is smaller than the node's data
        if ($data < $node->data) {
            $node->left = $this->deleteRec($node->left, $data);
        }
        // If the data to be deleted is greater than the node's data
        elseif ($data > $node->data) {
            $node->right = $this->deleteRec($node->right, $data);
        } else {
            // Node with only one child or no child
            if ($node->left === null) {
                $temp = $node->right;
                $node = null;
                return $temp;
            } elseif ($node->right === null) {
                $temp = $node->left;
                $node = null;
                return $temp;
            }

            // Node with two children: Get the inorder successor (smallest in the right subtree)
            $temp = $this->minValueNode($node->right);
            $node->data = $temp->data;
            $node->right = $this->deleteRec($node->right, $temp->data);
        }

        return $node;
    }

    // Find the node with the minimum value
    public function findMin() {
        $minNode = $this->minValueNode($this->root);
        return $minNode ? $minNode->data : null;
    }

    // Find the node with the maximum value
    public function findMax() {
        $maxNode = $this->maxValueNode($this->root);
        return $maxNode ? $maxNode->data : null;
    }

    // Helper function to find the node with the minimum value
    private function minValueNode($node) {
        $current = $node;
        while ($current && $current->left !== null) {
            $current = $current->left;
        }
        return $current;
    }

    // Helper function to find the node with the maximum value
    private function maxValueNode($node) {
        $current = $node;
        while ($current && $current->right !== null) {
            $current = $current->right;
        }
        return $current;
    }
}

// Example usage
$bst = new BinarySearchTree();

$bst->insert(50);
$bst->insert(30);
$bst->insert(20);
$bst->insert(40);
$bst->insert(70);
$bst->insert(60);
$bst->insert(80);

$bst->inOrder();
$bst->preOrder();
$bst->postOrder();

echo "Searching for 40: ";
$foundNode = $bst->search(40);
echo $foundNode ? "Found node with value " . $foundNode->data : "Node not found";
echo "\n";

echo "Minimum value in the tree: " . $bst->findMin() . "\n";
echo "Maximum value in the tree: " . $bst->findMax() . "\n";

$bst->delete(20);
$bst->inOrder();

$bst->delete(30);
$bst->inOrder();
?>
