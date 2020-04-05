<?php


use authentication\Authentication;

abstract class Item
{
    private string $name;
    private $value;

    public function __construct(string $name, $item)
    {
        $this->value = $item;
        $this->name = $name;
    }

    function getValue()
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

}

interface ItemSecurity
{
    public function CheckValidOwner();

    public function CheckItemExist();
}

interface Privater extends ItemSecurity
{
    public function CheckPrivatePost();
}

class PrivatePost extends Item implements Privater
{

    private Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function CheckValidOwner()
    {
        return $this->item->CheckValidOwner();
    }

    public function CheckItemExist()
    {
        return $this->item->CheckItemExist();
    }

    public function CheckPrivatePost()
    {

        return (new PrivatePostComposite(Authentication::getInstance()->getCurrentyUser()->getId(), $this->item->getValue()))->action();
    }
}


class CommentItem extends Item implements ItemSecurity
{


    public function CheckValidOwner()
    {

        return (new OwnerComposite(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->getValue(),
            "comments", "comment_id"))->action();
    }

    public function CheckItemExist()
    {
        return (new ItemExistComposite($this->getValue(), "comments","comment_id"))->action();
    }
}


class PostItem extends Item implements itemSecurity
{

    public function CheckValidOwner()
    {
        return (new OwnerComposite(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->getValue(),
            "post", "post_id"))->action();
    }

    public function CheckItemExist()
    {
        return (new ItemExistComposite($this->getValue(), "post","post_id"))->action();
    }
}