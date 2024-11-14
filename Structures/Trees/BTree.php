<?php

class BTreeNode {
    public $keys;
    public $children;
    public $leaf;
    public $t;

    public function __construct($t, $leaf = true) {
        $this->t = $t;
        $this->leaf = $leaf;
        $this->keys = [];
        $this->children = [];
    }
}

class BTree {
    private $root;
    private $t;

    public function __construct($t) {
        $this->root = new BTreeNode($t);
        $this->t = $t;
    }

    // Search for a key in the B-Tree
    public function search($key) {
        return $this->searchNode($this->root, $key);
    }

    private function searchNode($node, $key) {
        $i = 0;
        while ($i < count($node->keys) && $key > $node->keys[$i]) {
            $i++;
        }

        if ($i < count($node->keys) && $key === $node->keys[$i]) {
            return $node; // Key found
        }

        if ($node->leaf) {
            return null; // Key not found
        }

        return $this->searchNode($node->children[$i], $key);
    }

    // Insert a key into the B-Tree
    public function insert($key) {
        $root = $this->root;

        if (count($root->keys) === (2 * $this->t - 1)) {
            $newNode = new BTreeNode($this->t, false);
            $newNode->children[0] = $root; // Set the root as the first child of the new node
            $this->splitChild($newNode, 0);
            $this->root = $newNode;
            $this->insertNonFull($newNode, $key);
        } else {
            $this->insertNonFull($root, $key);
        }
    }

    private function insertNonFull($node, $key) {
        $i = count($node->keys) - 1;

        if ($node->leaf) {
            while ($i >= 0 && $key < $node->keys[$i]) {
                $i--;
            }
            array_splice($node->keys, $i + 1, 0, $key);
        } else {
            while ($i >= 0 && $key < $node->keys[$i]) {
                $i--;
            }
            $i++;
            if (count($node->children[$i]->keys) === (2 * $this->t - 1)) {
                $this->splitChild($node, $i);
                if ($key > $node->keys[$i]) {
                    $i++;
                }
            }
            $this->insertNonFull($node->children[$i], $key);
        }
    }

    private function splitChild($parentNode, $i) {
        $t = $this->t;
        $nodeToSplit = $parentNode->children[$i];
        $newNode = new BTreeNode($t, $nodeToSplit->leaf);

        // Move the last t-1 keys from nodeToSplit to newNode
        array_splice($newNode->keys, 0, 0, array_splice($nodeToSplit->keys, $t, $t - 1));

        if (!$nodeToSplit->leaf) {
            array_splice($newNode->children, 0, 0, array_splice($nodeToSplit->children, $t, $t));
        }

        // Insert the new node into the parentNode
        array_splice($parentNode->keys, $i, 0, $nodeToSplit->keys[$t - 1]);
        array_splice($parentNode->children, $i + 1, 0, $newNode);
        $nodeToSplit->keys = array_splice($nodeToSplit->keys, 0, $t - 1);
    }

    // Delete a key from the B-Tree
    public function delete($key) {
        $this->deleteNode($this->root, $key);
    }

    private function deleteNode($node, $key) {
        $t = $this->t;
        $i = 0;
        while ($i < count($node->keys) && $key > $node->keys[$i]) {
            $i++;
        }

        if ($i < count($node->keys) && $node->keys[$i] === $key) {
            if ($node->leaf) {
                // Key is in a leaf node, simply remove it
                array_splice($node->keys, $i, 1);
            } else {
                $this->deleteInternalNode($node, $i);
            }
        } else {
            if ($node->leaf) {
                return; // Key not found
            }

            $childNode = $node->children[$i];

            if (count($childNode->keys) === $t - 1) {
                $this->fill($node, $i);
                if ($key > $node->keys[$i]) {
                    $childNode = $node->children[$i + 1];
                }
            }

            $this->deleteNode($childNode, $key);
        }
    }

    private function deleteInternalNode($node, $i) {
        $t = $this->t;
        $key = $node->keys[$i];

        if (count($node->children[$i]->keys) >= $t) {
            $predecessor = $this->getPredecessor($node, $i);
            $node->keys[$i] = $predecessor;
            $this->deleteNode($node->children[$i], $predecessor);
        } else if (count($node->children[$i + 1]->keys) >= $t) {
            $successor = $this->getSuccessor($node, $i);
            $node->keys[$i] = $successor;
            $this->deleteNode($node->children[$i + 1], $successor);
        } else {
            $this->merge($node, $i);
            $this->deleteNode($node->children[$i], $key);
        }
    }

    private function getPredecessor($node, $i) {
        $current = $node->children[$i];
        while (!$current->leaf) {
            $current = $current->children[count($current->children) - 1];
        }
        return $current->keys[count($current->keys) - 1];
    }

    private function getSuccessor($node, $i) {
        $current = $node->children[$i + 1];
        while (!$current->leaf) {
            $current = $current->children[0];
        }
        return $current->keys[0];
    }

    private function fill($node, $i) {
        $t = $this->t;
        if ($i > 0 && count($node->children[$i - 1]->keys) >= $t) {
            $this->borrowFromPrevious($node, $i);
        } else if ($i < count($node->keys) && count($node->children[$i + 1]->keys) >= $t) {
            $this->borrowFromNext($node, $i);
        } else {
            if ($i < count($node->keys)) {
                $this->merge($node, $i);
            } else {
                $this->merge($node, $i - 1);
            }
        }
    }

    private function borrowFromPrevious($node, $i) {
        $child = $node->children[$i];
        $sibling = $node->children[$i - 1];

        array_unshift($child->keys, $node->keys[$i - 1]);
        $node->keys[$i - 1] = array_pop($sibling->keys);

        if (!$child->leaf) {
            array_unshift($child->children, array_pop($sibling->children));
        }
    }

    private function borrowFromNext($node, $i) {
        $child = $node->children[$i];
        $sibling = $node->children[$i + 1];

        array_push($child->keys, $node->keys[$i]);
        $node->keys[$i] = array_shift($sibling->keys);

        if (!$child->leaf) {
            array_push($child->children, array_shift($sibling->children));
        }
    }

    private function merge($node, $i) {
        $child = $node->children[$i];
        $sibling = $node->children[$i + 1];

        $child->keys[] = $node->keys[$i];
        array_splice($node->keys, $i, 1);
        array_splice($node->children, $i + 1, 1);

        array_splice($child->keys, count($child->keys), 0, $sibling->keys);
        array_splice($child->children, count($child->children), 0, $sibling->children);

        unset($sibling);
    }

    // Traversal: In-order traversal
    public function inOrderTraversal() {
        $this->inOrderTraversalRec($this->root);
    }

    private function inOrderTraversalRec($node) {
        $i = 0;
        while ($i < count($node->keys)) {
            if (!$node->leaf) {
                $this->inOrderTraversalRec($node->children[$i]);
            }
            echo $node->keys[$i] . " ";
            $i++;
        }

        if (!$node->leaf) {
            $this->inOrderTraversalRec($node->children[$i]);
        }
    }
}

$btree = new BTree(3); // Creating a B-tree with minimum degree 3

// Insert elements
$btree->insert(10);
$btree->insert(20);
$btree->insert(5);
$btree->insert(6);
$btree->insert(12);
$btree->insert(30);
$btree->insert(7);
$btree->insert(17);

// In-order traversal
echo "In-order traversal: ";
$btree->inOrderTraversal(); // Output should be in sorted order
echo "\n";

// Search for a key
$searchKey = 12;
$result = $btree->search($searchKey);
if ($result) {
    echo "Found key $searchKey\n";
} else {
    echo "Key $searchKey not found\n";
}

// Delete a key
$btree->delete(12);
echo "After deletion of key 12, In-order traversal: ";
$btree->inOrderTraversal();