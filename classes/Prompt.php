<?php

require_once(__DIR__ . "/Database.php");

class Prompt
{
    // Basic information
    private string $title;
    private string $description;
    private int $authorId;

    // Model information
    private int $modelId;
    private $modelIds = null;
    private string $modelVersion;

    //Categories & tags
    private string $tags;
    private $categoryIds = null;

    // Prompt information
    private bool $isFree = false;
    private string $prompt;
    private string $promptInstructions;
    private int $wordCount;

    // Images
    private string $headerImage;
    private string $exampleImage1;
    private $exampleImage2 = null;
    private $exampleImage3 = null;
    private $exampleImage4 = null;

    // Getters

    
    // Setters

    public function setTitle (string $title)
    {
        if (strlen($title) >= 70) {
            throw new Exception("Title must be less than 70 characters.");
        } else if (empty($title)) {
            throw new Exception("Title cannot be empty.");
        }

        $this->title = $title;
        return $this;
    }

    public function setDescription (string $description)
    {
        if (strlen($description) >= 500) {
            throw new Exception("Description must be less than 500 characters.");
        } else if (empty($description)) {
            throw new Exception("Description cannot be empty.");
        }

        $this->description = $description;
        return $this;
    }

    public function setTags (string $tags)
    {
        if (empty($tags)) {
            throw new Exception("Tags cannot be empty.");
        }

        $tags = preg_replace("/(?<=,)\s*|\s*(?=,)/", '', $tags);
        $tags = explode(",", $tags);

        foreach($tags as $tag) {
            if (strlen($tag) > 20) {
                throw new Exception("Single tag must be less than 20 characters.");
            } else if (strlen($tag) < 2) {
                throw new Exception("Single tag must be more than or equal to 2 characters.");
            } else if (preg_match('/([^a-zA-Z0-9\s])/', $tag) === 1) {
                throw new Exception("Tags can only contain letters, numbers, and spaces.");
            }
        };

        $tags = json_encode($tags);
        
        $this->tags = $tags;
        return $this;
    }

    public function setCategories (string $categories)
    {   
        $categoryIds = json_decode($categories);

        if (empty($categoryIds)) {
            throw new Exception("Please select at least one category");
        }

        $PDO = Database::getInstance();
        $stmt = $PDO->query("select id from categories");
        $stmt->execute();

        $dbCategories = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($categoryIds as $categoryId) {
            if (!in_array($categoryId, $dbCategories)) {
                throw new Exception("Given category id does not match to any categories.");
            }
        }

        $this->categoryIds = $categoryIds;
        return $this;
    }

    public function setModelId (int $modelId)
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("select * from ai_models where id = :id");
        $stmt->bindValue(":id", $modelId);
        $stmt->execute();

        if ($stmt->fetch() === false) {
            throw new Exception("Chosen model does not exist.");
        }

        $this->modelId = $modelId;
        return $this;
    }

    public function setModels (string $modelIds)
    {
        $modelIds = json_decode($modelIds);

        if (empty($modelIds)) {
            throw new Exception("Please select at least one model");
        }

        $PDO = Database::getInstance();
        $stmt = $PDO->query("select id from ai_models");
        $stmt->execute();

        $dbModelIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($modelIds as $modelId) {
            if (!in_array($modelId, $dbModelIds)) {
                throw new Exception("Given model id does not match to any models.");
            }
        }

        $this->modelIds = $modelIds;
        return $this;
    }

    public function setModelVersion (string $modelVersion)
    {
        $modelVersions = Prompt::getModelVersions($this->modelId);
        
        if (!in_array($modelVersion, $modelVersions)) {
            throw new Exception("Given version does not match with the given model");
        }

        $this->modelVersion = $modelVersion;
        return $this;
    }

    public function setPrompt (string $prompt)
    {
        if (empty($prompt)) {
            throw new Exception("Prompt cannot be empty.");
        }

        $this->wordCount = str_word_count($prompt);
        $this->prompt = $prompt;
        return $this;
    }

    public function setPromptInstructions (string $instructions)
    {
        if (empty($instructions)) {
            throw new Exception("Instructions cannot be empty");
        }

        $this->promptInstructions = $instructions;
        return $this;
    }

    public function setAuthorId (int $id)
    {
        $this->authorId = $id;
        return $this;
    }

    public function setIsFree (bool $free)
    {
        $this->isFree = $free;
        return $this;
    }

    public function setHeaderImage (string $imgPath)
    {
        $this->headerImage = $imgPath;
        return $this;
    }

    public function setExampleImage1 (string $imgPath)
    {
        $this->exampleImage1 = $imgPath;
        return $this;
    }

    public function setExampleImage2 (string $imgPath)
    {
        $this->exampleImage2 = $imgPath;
        return $this;
    }

    public function setExampleImage3 (string $imgPath)
    {
        $this->exampleImage3 = $imgPath;
        return $this;
    }

    public function setExampleImage4 (string $imgPath)
    {
        $this->exampleImage4 = $imgPath;
        return $this;
    }


    // Insert, update, delete ...

    public function insertPrompt(): void
    {
        // INSERT PROMPT
        $sql = "INSERT INTO prompts (title, description, tags, prompt, prompt_instructions, word_count, author_id, model_id, model_version, header_image, example_image1, example_image2, example_image3, example_image4, free) VALUES (:title, :description, :tags, :prompt, :prompt_instructions, :word_count, :author_id, :model_id, :model_version, :header_image, :example_image1, :example_image2, :example_image3, :example_image4, :free)";

        $PDO = Database::getInstance();
        $stmt = $PDO->prepare($sql);

        // basic stuff & tags
        $stmt->bindValue(":title", $this->title);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":tags", $this->tags);
        $stmt->bindValue(":author_id", $this->authorId);

        // prompt stuff
        $stmt->bindValue(":prompt", $this->prompt);
        $stmt->bindValue(":prompt_instructions", $this->promptInstructions);
        $stmt->bindValue(":word_count", $this->wordCount);
        $stmt->bindValue(":free", $this->isFree);

        // model stuff
        $stmt->bindValue(":model_id", $this->modelId);
        $stmt->bindValue(":model_version", $this->modelVersion);

        // images
        $stmt->bindValue(":header_image", $this->headerImage);
        $stmt->bindValue(":example_image1", $this->exampleImage1);
        $stmt->bindValue(":example_image2", $this->exampleImage2);
        $stmt->bindValue(":example_image3", $this->exampleImage3);
        $stmt->bindValue(":example_image4", $this->exampleImage4);

        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count == 0) throw new Exception("Server error. Something went wrong. Try again later.");


        // INSERT CATEGORIES

        $promptId = $PDO->lastInsertId();

        foreach ($this->categoryIds as $categoryId) {
            $stmt2 = $PDO->prepare("INSERT INTO category_prompt (prompt_id, category_id) VALUES (:prompt_id, :category_id)");
            $stmt2->bindValue(":prompt_id", $promptId);
            $stmt2->bindValue(":category_id", $categoryId);
            $stmt2->execute();

            $count = $stmt->rowCount();

            if ($count == 0) throw new Exception("Server error. Something went wrong. Try again later.");
        }
    }


    public function getPrompts (string $order = "new", int $page = 1, int $approved = null): array
    {
        $limit = 20;
        $offset = ($page - 1) * $limit;

        switch ($order) {
            case "new":
                $sqlOrder = " ORDER BY prompts.date_created DESC";
                break;
            case "popular":
                $sqlOrder = " ORDER BY prompts.views DESC";
                break;
            case "a-z":
                $sqlOrder = " ORDER BY prompts.title ASC";
                break;
            default:
                $sqlOrder = " ORDER BY prompts.date_created DESC";
                break;
        }

        if ($this->categoryIds != null) { // should be save from sql injection because already validated
            $categoryIn = implode(",", $this->categoryIds);
        } else {
            $categoryIn = "category_prompt.category_id";
        }

        if ($this->modelIds != null) {
            $modelIn = implode(",", $this->modelIds);
        } else {
            $modelIn = "prompts.model_id";
        }

        $sql = "SELECT prompts.*
                FROM prompts 
                JOIN category_prompt ON prompts.id = category_prompt.prompt_id 
                WHERE prompts.approved = CASE WHEN :approved IS NOT NULL AND LENGTH(:approved) > 0 THEN :approved ELSE prompts.approved END
                AND prompts.model_id IN (" . $modelIn . ")
                AND category_prompt.category_id IN (" . $categoryIn . ")
                GROUP BY prompts.id" 
                . $sqlOrder .
                " LIMIT :limit OFFSET :offset";

        $PDO = Database::getInstance();
        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":approved", $approved);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPromptById (int $id): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT * FROM prompts WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) throw new Exception("Prompt not found.");

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function addView (int $id): void
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("UPDATE prompts SET views = views + 1 WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }


    // AI model methods

    public static function getModelById (int $id): array 
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("select * from ai_models where id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllModels(): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->query("select * from ai_models");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getModelVersions(int $id)
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("select versions from ai_models where id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = json_decode($result['versions']);

        return $result;
    }


    // Category methods

    public static function getAllCategories(): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->query("select * from categories");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategoriesByPromptId (int $id): array
    {
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare("SELECT categories.* FROM categories JOIN category_prompt ON categories.id = category_prompt.category_id WHERE category_prompt.prompt_id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}