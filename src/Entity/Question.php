<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    CONST LEVEL_EASY_CODE = 1;
    CONST LEVEL_EASY_LABEL = 'Débutant';
    CONST LEVEL_MEDIUM_CODE = 2;
    CONST LEVEL_MEDIUM_LABEL = 'Intermédiaire';
    CONST LEVEL_HARD_CODE = 3;
    CONST LEVEL_HARD_LABEL = 'Avancéant';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Answerchoice", mappedBy="question", cascade={"persist", "remove"})
     */
    private $answerchoices;

    /**
     * @ORM\ManyToMany(targetEntity="Test", inversedBy="questions")
     */
    private $tests;

    /**
     * @ORM\OneToMany(targetEntity="Score", mappedBy="question")
     */
    private $questionScores;

    public function __construct()
    {
        $this->answerchoices = new ArrayCollection();
        $this->tests = new ArrayCollection();
        $this->questionScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Answerchoice[]
     */
    public function getAnswerchoices(): Collection
    {
        return $this->answerchoices;
    }

    public function addAnswerchoice(Answerchoice $answerchoice): self
    {
        if (!$this->answerchoices->contains($answerchoice)) {
            $this->answerchoices[] = $answerchoice;
            $answerchoice->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswerchoice(Answerchoice $answerchoice): self
    {
        if ($this->answerchoices->contains($answerchoice)) {
            $this->answerchoices->removeElement($answerchoice);
            // set the owning side to null (unless already changed)
            if ($answerchoice->getQuestion() === $this) {
                $answerchoice->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
        }

        return $this;
    }

    public function getLevelList()
    {
        return [
            Question::LEVEL_EASY_CODE   => Question::LEVEL_EASY_LABEL,
            Question::LEVEL_MEDIUM_CODE => Question::LEVEL_MEDIUM_LABEL,
            Question::LEVEL_HARD_CODE   => Question::LEVEL_HARD_LABEL,
        ];
    }

    public static function getLevelListForChoice()
    {
        return [
            Question::LEVEL_EASY_LABEL   => Question::LEVEL_EASY_CODE,
            Question::LEVEL_MEDIUM_LABEL => Question::LEVEL_MEDIUM_CODE,
            Question::LEVEL_HARD_LABEL   => Question::LEVEL_HARD_CODE,
        ];
    }

    public function getLevelLabel()
    {
        $levelList = $this->getLevelList();

        return $levelList[$this->getLevel()];
    }

    /**
     * @return Collection|Score[]
     */
    public function getQuestionScores(): Collection
    {
        return $this->questionScores;
    }

    public function addQuestionScore(Score $questionScore): self
    {
        if (!$this->questionScores->contains($questionScore)) {
            $this->questionScores[] = $questionScore;
            $questionScore->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionScore(Score $questionScore): self
    {
        if ($this->questionScores->contains($questionScore)) {
            $this->questionScores->removeElement($questionScore);
            // set the owning side to null (unless already changed)
            if ($questionScore->getQuestion() === $this) {
                $questionScore->setQuestion(null);
            }
        }

        return $this;
    }
}
