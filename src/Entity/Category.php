<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @Vich\Uploadable
 */
class Category
{
    public function __toString()
    {
        return $this->title;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $metaTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meteDescription;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="categories")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="parent", cascade={"persist", "remove"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="category", cascade={"persist", "remove"})
     */
    private $posts;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $redirectToPost;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDarkLocalMenu;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int|null
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=FlashMessage::class, mappedBy="category")
     */
    private $flashMessages;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isShown;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isLead;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->mainMenus = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->flashMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMeteDescription(): ?string
    {
        return $this->meteDescription;
    }

    public function setMeteDescription(?string $meteDescription): self
    {
        $this->meteDescription = $meteDescription;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setParent($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getParent() === $this) {
                $category->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

        return $this;
    }

    public function getRedirectToPost(): ?bool
    {
        return $this->redirectToPost;
    }

    public function setRedirectToPost(?bool $redirectToPost): self
    {
        $this->redirectToPost = $redirectToPost;

        return $this;
    }

    public function getIsDarkLocalMenu(): ?bool
    {
        return $this->isDarkLocalMenu;
    }

    public function setIsDarkLocalMenu(?bool $isDarkLocalMenu): self
    {
        $this->isDarkLocalMenu = $isDarkLocalMenu;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return Collection|FlashMessage[]
     */
    public function getFlashMessages(): Collection
    {
        return $this->flashMessages;
    }

    public function addFlashMessage(FlashMessage $flashMessage): self
    {
        if (!$this->flashMessages->contains($flashMessage)) {
            $this->flashMessages[] = $flashMessage;
            $flashMessage->setCategory($this);
        }

        return $this;
    }

    public function removeFlashMessage(FlashMessage $flashMessage): self
    {
        if ($this->flashMessages->contains($flashMessage)) {
            $this->flashMessages->removeElement($flashMessage);
            // set the owning side to null (unless already changed)
            if ($flashMessage->getCategory() === $this) {
                $flashMessage->setCategory(null);
            }
        }

        return $this;
    }

    public function getIsShown(): ?bool
    {
        return $this->isShown;
    }

    public function setIsShown(?bool $isShown): self
    {
        $this->isShown = $isShown;

        return $this;
    }

    public function getIsLead(): ?bool
    {
        return $this->isLead;
    }

    public function setIsLead(?bool $isLead): self
    {
        $this->isLead = $isLead;

        return $this;
    }

}
