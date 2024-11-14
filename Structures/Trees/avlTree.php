<?php

// Node class to represent each node in the AVL tree
class Node {
    public $data;
    public $left;
    public $right;
    public $height;

    public function __construct($data) {
        $this->data = $data;
        $this->left = null;
        $this->right = null;
        $this->height = 1;
    }
}

// AVLTree class to manage the AVL tree
class AVLTree {
    private $root;

    public function __construct() {
        $this->root = null;
    }

    // Get the height of a node
    private function getHeight($node) {
        if ($node === null) {
            return 0;
        }
        return $node->height;
    }

    // Get the balance factor of a node
    private function getBalance($node) {
        if ($node === null) {
            return 0;
        }
        return $this->getHeight($node->left) - $this->getHeight($node->right);
    }

    // Right rotate the subtree rooted at y
    private function rightRotate($y) {
        $x = $y->left;
        $T2 = $x->right;

        // Perform rotation
        $x->right = $y;
        $y->left = $T2;

        // Update heights
        $y->height = max($this->getHeight($y->left), $this->getHeight($y->right)) + 1;
        $x->height = max($this->getHeight($x->left), $this->getHeight($x->right)) + 1;

        // Return the new root
        return $x;
    }

    // Left rotate the subtree rooted at x
    private function leftRotate($x) {
        $y = $x->right;
        $T2 = $y->left;

        // Perform rotation
        $y->left = $x;
        $x->right = $T2;

        // Update heights
        $x->height = max($this->getHeight($x->left), $this->getHeight($x->right)) + 1;
        $y->height = max($this->getHeight($y->left), $this->getHeight($y->right)) + 1;

        // Return the new root
        return $y;
    }

    // Insert a node into the AVL tree
    public function insert($data) {
        $this->root = $this->insertRec($this->root, $data);
    }

    // Helper function to insert a node (recursively)
    private function insertRec($node, $data) {
        if ($node === null) {
            return new Node($data);
        }

        // Perform normal BST insert
        if ($data < $node->data) {
            $node->left = $this->insertRec($node->left, $data);
        } else if ($data > $node->data) {
            $node->right = $this->insertRec($node->right, $data);
        } else {
            return $node; // Duplicates are not allowed in the AVL tree
        }

        // Update height of this ancestor node
        $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;

        // Get the balance factor
        $balance = $this->getBalance($node);

        // Balance the tree if needed

        // Left heavy subtree
        if ($balance > 1 && $data < $node->left->data) {
            return $this->rightRotate($node);
        }

        // Right heavy subtree
        if ($balance < -1 && $data > $node->right->data) {
            return $this->leftRotate($node);
        }

        // Left-Right heavy subtree
        if ($balance > 1 && $data > $node->left->data) {
            $node->left = $this->leftRotate($node->left);
            return $this->rightRotate($node);
        }

        // Right-Left heavy subtree
        if ($balance < -1 && $data < $node->right->data) {
            $node->right = $this->rightRotate($node->right);
            return $this->leftRotate($node);
        }

        return $node;
    }

    // Search for a node with a specific value
    public function search($data) {
        return $this->searchRec($this->root, $data);
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

    // Delete a node from the AVL tree
    public function delete($data) {
        $this->root = $this->deleteRec($this->root, $data);
    }

    // Helper function for deleting a node (recursively)
    private function deleteRec($node, $data) {
        if ($node === null) {
            return $node;
        }

        // Perform normal BST delete
        if ($data < $node->data) {
            $node->left = $this->deleteRec($node->left, $data);
        } else if ($data > $node->data) {
            $node->right = $this->deleteRec($node->right, $data);
        } else {
            // Node to be deleted is found

            // Node with only one child or no child
            if ($node->left === null) {
                $temp = $node->right;
                $node = null;
                return $temp;
            } else if ($node->right === null) {
                $temp = $node->left;
                $node = null;
                return $temp;
            }

            // Node with two children: Get the inorder successor (smallest in the right subtree)
            $temp = $this->minValueNode($node->right);

            // Copy the inorder successor's data to this node
            $node->data = $temp->data;

            // Delete the inorder successor
            $node->right = $this->deleteRec($node->right, $temp->data);
        }

        // Update the height of the current node
        $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;

        // Get the balance factor
        $balance = $this->getBalance($node);

        // Balance the tree if needed

        // Left heavy subtree
        if ($balance > 1 && $this->getBalance($node->left) >= 0) {
            return $this->rightRotate($node);
        }

        // Right heavy subtree
        if ($balance < -1 && $this->getBalance($node->right) <= 0) {
            return $this->leftRotate($node);
        }

        // Left-Right heavy subtree
        if ($balance > 1 && $this->getBalance($node->left) < 0) {
            $node->left = $this->leftRotate($node->left);
            return $this->rightRotate($node);
        }

        // Right-Left heavy subtree
        if ($balance < -1 && $this->getBalance($node->right) > 0) {
            $node->right = $this->rightRotate($node->right);
            return $this->leftRotate($node);
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
$avl = new AVLTree();
$avl->insert(50);
$avl->insert(30);
$avl->insert(20);
$avl->insert(40);
$avl->insert(70);
$avl->insert(60);
$avl->insert(80);

$avl->inOrder();  // In-order traversal
$avl->preOrder(); // Pre-order traversal
$avl->postOrder(); // Post-order traversal

echo "Searching for 40: ";
$node = $avl->search(40);
echo $node ? "Found node with value " . $node->data : "Node not found";
echo "\n";

$avl->delete(20);
$avl->inOrder();

$avl->delete(30);
$avl->inOrder();
?>
