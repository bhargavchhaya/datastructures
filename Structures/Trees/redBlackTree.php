<?php

// Enum to define color constants for the Red-Black Tree
class Color {
    const RED = 0;
    const BLACK = 1;
}

// Node class for each node in the Red-Black Tree
class Node {
    public $data;
    public $color;
    public $left;
    public $right;
    public $parent;

    public function __construct($data) {
        $this->data = $data;
        $this->color = Color::RED;  // New nodes are always red
        $this->left = null;
        $this->right = null;
        $this->parent = null;
    }
}

// RedBlackTree class for Red-Black Tree operations
class RedBlackTree {
    private $root;

    public function __construct() {
        $this->root = null;
    }

    // Perform a left rotation
    private function leftRotate($x) {
        $y = $x->right;
        $x->right = $y->left;

        if ($y->left !== null) {
            $y->left->parent = $x;
        }

        $y->parent = $x->parent;

        if ($x->parent === null) {
            $this->root = $y;
        } else if ($x === $x->parent->left) {
            $x->parent->left = $y;
        } else {
            $x->parent->right = $y;
        }

        $y->left = $x;
        $x->parent = $y;
    }

    // Perform a right rotation
    private function rightRotate($y) {
        $x = $y->left;
        $y->left = $x->right;

        if ($x->right !== null) {
            $x->right->parent = $y;
        }

        $x->parent = $y->parent;

        if ($y->parent === null) {
            $this->root = $x;
        } else if ($y === $y->parent->right) {
            $y->parent->right = $x;
        } else {
            $y->parent->left = $x;
        }

        $x->right = $y;
        $y->parent = $x;
    }

    // Fix the Red-Black Tree properties after insertion
    private function fixInsert($k) {
        while ($k->parent !== null && $k->parent->color === Color::RED) {
            if ($k->parent === $k->parent->parent->left) {
                $uncle = $k->parent->parent->right;

                // Case 1: Uncle is red
                if ($uncle !== null && $uncle->color === Color::RED) {
                    $k->parent->color = Color::BLACK;
                    $uncle->color = Color::BLACK;
                    $k->parent->parent->color = Color::RED;
                    $k = $k->parent->parent;
                } else {
                    // Case 2: k is the right child of its parent
                    if ($k === $k->parent->right) {
                        $k = $k->parent;
                        $this->leftRotate($k);
                    }

                    // Case 3: k is the left child of its parent
                    $k->parent->color = Color::BLACK;
                    $k->parent->parent->color = Color::RED;
                    $this->rightRotate($k->parent->parent);
                }
            } else {
                $uncle = $k->parent->parent->left;

                // Case 1: Uncle is red
                if ($uncle !== null && $uncle->color === Color::RED) {
                    $k->parent->color = Color::BLACK;
                    $uncle->color = Color::BLACK;
                    $k->parent->parent->color = Color::RED;
                    $k = $k->parent->parent;
                } else {
                    // Case 2: k is the left child of its parent
                    if ($k === $k->parent->left) {
                        $k = $k->parent;
                        $this->rightRotate($k);
                    }

                    // Case 3: k is the right child of its parent
                    $k->parent->color = Color::BLACK;
                    $k->parent->parent->color = Color::RED;
                    $this->leftRotate($k->parent->parent);
                }
            }
        }

        $this->root->color = Color::BLACK;
    }

    // Insert a new node into the Red-Black Tree
    public function insert($data) {
        $newNode = new Node($data);
        $this->insertNode($newNode);
    }

    // Helper function for inserting a new node
    private function insertNode($newNode) {
        $y = null;
        $x = $this->root;

        // Perform normal binary search tree insertion
        while ($x !== null) {
            $y = $x;
            if ($newNode->data < $x->data) {
                $x = $x->left;
            } else {
                $x = $x->right;
            }
        }

        $newNode->parent = $y;

        if ($y === null) {
            $this->root = $newNode;
        } else if ($newNode->data < $y->data) {
            $y->left = $newNode;
        } else {
            $y->right = $newNode;
        }

        // Fix the Red-Black Tree properties after insertion
        $this->fixInsert($newNode);
    }

    // In-order traversal of the Red-Black Tree
    public function inOrder() {
        echo "In-order traversal: ";
        $this->inOrderRec($this->root);
        echo "\n";
    }

    private function inOrderRec($node) {
        if ($node !== null) {
            $this->inOrderRec($node->left);
            echo $node->data . " ";
            $this->inOrderRec($node->right);
        }
    }

    // Search for a node with a specific value
    public function search($data) {
        return $this->searchRec($this->root, $data);
    }

    // Helper function for searching a node
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
}

// Example usage
$rbTree = new RedBlackTree();
$rbTree->insert(10);
$rbTree->insert(20);
$rbTree->insert(30);
$rbTree->insert(15);
$rbTree->insert(25);
$rbTree->insert(5);

$rbTree->inOrder(); // In-order traversal
echo "\nSearching for 15: ";
$node = $rbTree->search(15);
echo $node ? "Found node with value " . $node->data : "Node not found";
echo "\n";

?>
