<?php


namespace authentication {

//Schema of users information to store users information

    use BuilderComposite;
    use DateTime;
    use Exception;

    abstract class SchemaBuilder
    {
        protected $data;

        protected function assignValue(string $value)
        {
            return is_array($this->data) ? $this->data[$value] : $this->data->{$value};
        }

        protected function assignDataValue($value)
        {
            $value = $this->assignValue($value);
            try {
                return ($value instanceof DateTime) ? $value : new DateTime($value);
            } catch (Exception $e) {
                throw new Exception("This format is not allowed");
            }
        }

        public function __construct($data)
        {
            $this->data = $data;
        }

        abstract public function toIterate(): array;


    }


    class CategorySchema extends SchemaBuilder
    {

        public const TITLE = 'category_title';
        public const CONTENT = 'category_content';
        private string $title;


        private string $content;


        public function __construct($data)
        {
            parent::__construct($data);
            $this->title = $this->assignValue(self::TITLE);
            $this->content = $this->assignValue(self::CONTENT);
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getContent()
        {
            return $this->content;
        }

        public function toIterate(): array
        {
            return [self::CONTENT => $this->content,
                self::TITLE => $this->title];
        }
    }

    class ResourcesSchema extends SchemaBuilder
    {
        private string $id;
        private string $firstname;
        private string $lastname;
        private string $mobile;
        private string $intro;
        private string $profile;
        private string $image;
        private string $user;

        public const ID = 'resources_id';
        public const FIRSTNAME = 'firstName';
        public const LASTNAME = 'lastName';
        public const MOBILE = 'mobile';
        public const INTRO = 'intro';
        public const PROFILE = 'profile';
        public const IMAGE = 'image';

        public function __construct($data)
        {
            SchemaBuilder::__construct($data);
            $this->id = $this->assignValue(self::ID);
            $this->firstname = $this->assignValue(self::FIRSTNAME);
            $this->lastname = $this->assignValue(self::LASTNAME);
            $this->mobile = $this->assignValue(self::MOBILE);
            $this->intro = $this->assignValue(self::INTRO);
            $this->profile = $this->assignValue(self::PROFILE);
            $this->image = $this->assignValue(self::IMAGE);
        }

        public function getUser()
        {
            return $this->user;
        }

        public function getId(): string
        {
            return $this->id;
        }

        public function getFirstname(): string
        {
            return $this->firstname;
        }

        public function getLastname(): string
        {
            return $this->lastname;
        }

        public function getMobile(): string
        {
            return $this->mobile;
        }

        public function getIntro(): string
        {
            return $this->intro;
        }

        public function getProfile(): string
        {
            return $this->profile;
        }

        public function getImage(): string
        {
            return $this->image;
        }

        public function toIterate(): array
        {
            return [self::FIRSTNAME => $this->getFirstname(),
                self::LASTNAME => $this->getLastname(),
                self::MOBILE => $this->getMobile(),
                self::ID => $this->getId(),
                self::INTRO => $this->getIntro(),
                self::PROFILE => $this->getProfile(),
                self::IMAGE => $this->getImage()];
        }
    }


    class AuthenticationSchema extends SchemaBuilder
    {
        const USERNAME = "username";
        const PASSWORD = "password";
        const EMAIL = "email";
        const ID = "id";
        const PERMMISION = "permission";
        const REGISTEREDAT = 'registeredAt';
        const LASTLOGIN = 'lastLogin';
        const UNKNOW = "unknow";

        protected ResourcesSchema $resources;
        protected string $id;
        protected string $username;
        protected string $password;
        protected string $email;
        protected string $permission;
        protected DateTime $registeredAt;
        protected DateTime $lastLogin;

        public function __construct($data)
        {
            // duzo zmian

            SchemaBuilder::__construct($data);
            $this->username = $this->assignValue(self::USERNAME);
            $this->password = $this->assignValue(self::PASSWORD);
            $this->email = $this->assignValue(self::EMAIL);
            $this->id = $this->assignValue(self::ID);
            $this->permission = $this->assignValue(self::PERMMISION);
            $this->registeredAt = $this->assignDataValue(self::REGISTEREDAT);
            $this->lastLogin = $this->assignDataValue(self::LASTLOGIN);
        }

        public static function createGuest()
        {
            return new AuthenticationSchema(["username" => "Guest",
                "password" => AuthenticationSchema::UNKNOW,
                "email" => AuthenticationSchema::UNKNOW,
                "id" => uniqid("UNKNOW", true),
                "permission" => Permmision::GUEST,
                "registeredAt" => new DateTime(),
                "lastLogin" => new DateTime()]);
        }


        public function AssingResources(ResourcesSchema $user)
        {
            $this->resources = $user;
        }

        public function GetResouces()
        {

            return $this->resources;
        }

        private function idCollision()
        {
            return ($this->data['user_id']) ? $this->data['user_id'] : $this->data['id'];
        }


        public function getRegisteredDate()
        {
            return $this->registeredAt;
        }

        public function loginTime()
        {
            return $this->lastLogin;
        }

        public function getPermission()
        {
            return $this->permission;
        }

        public function getUsername(): string
        {
            return $this->username;
        }

        public function getPassword(): string
        {
            return $this->password;
        }


        public function getEmail(): string
        {
            return $this->email;
        }

        public function getId(): string
        {
            return $this->id;
        }

        public function toIterate(): array
        {
            return [self::USERNAME => $this->getUsername(),
                self::PASSWORD => $this->getPassword(),
                self::EMAIL => $this->getEmail(),
                self::ID => $this->getId(),
                self::PERMMISION => $this->getPermission(),
                self::REGISTEREDAT => $this->getRegisteredDate()->format(BuilderComposite::DATEFORMAT),
                self::LASTLOGIN => $this->loginTime()->format(BuilderComposite::DATEFORMAT)];
        }
    }
}