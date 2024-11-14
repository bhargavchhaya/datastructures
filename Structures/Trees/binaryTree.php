<?php

// Node class to represent each node in the binary tree
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

// BinaryTree class to manage the binary tree
class BinaryTree {
    private $root;

    public function __construct() {
        $this->root = null;
    }

    // Insert a node into the binary tree
    public function insert($data) {
        $newNode = new Node($data);

        if ($this->root === null) {
            $this->root = $newNode;
        } else {
            $this->insertRec($this->root, $newNode);
        }
        echo "Inserted $data into the tree\n";
    }

    // Helper function for inserting nodes (recursively)
    private function insertRec($node, $newNode) {
        if ($newNode->data < $node->data) {
            if ($node->left === null) {
                $node->left = $newNode;
            } else {
                $this->insertRec($node->left, $newNode);
            }
        } else {
            if ($node->right === null) {
                $node->right = $newNode;
            } else {
                $this->insertRec($node->right, $newNode);
            }
        }
    }

    // Search for a node with a specific value
    public function search($data) {
        return $this->searchRec($this->root, $data);
    }

    // Helper function for searching (recursively)
    private function searchRec($node, $data) {
        if ($node === null) {
            return null;
        }

        if ($node->data === $data) {
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
    }

    // Helper function for deleting a node (recursively)
    private function deleteRec($node, $data) {
        if ($node === null) {
            return $node;
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
    private function minValueNode($node) {
        $current = $node;
        while ($current->left !== null) {
            $current = $current->left;
        }
        return $current;
    }
}

// Example usage
$binaryTree = new BinaryTree();

$binaryTree->insert(50);
$binaryTree->insert(30);
$binaryTree->insert(20);
$binaryTree->insert(40);
$binaryTree->insert(70);
$binaryTree->insert(60);
$binaryTree->insert(80);

echo "In-order traversal: ";
$binaryTree->inOrder();

echo "Pre-order traversal: ";
$binaryTree->preOrder();

echo "Post-order traversal: ";
$binaryTree->postOrder();

echo "Searching for 40: ";
$foundNode = $binaryTree->search(40);
echo $foundNode ? "Found node with value " . $foundNode->data : "Node not found";
echo "\n";

echo "Deleting node with value 20:\n";
$binaryTree->delete(20);
$binaryTree->inOrder();

echo "Deleting node with value 30:\n";
$binaryTree->delete(30);
$binaryTree->inOrder();
?>
