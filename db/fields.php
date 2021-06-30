<?php

    class Field {

        public string $name;
        public $value = null;
        public int $maxLen;
        public string $type;
        public string $validation;
        public bool $isError = false;
        public string $errorMsg;

        public function __construct(

            string $name,
            int $maxLen,
            string $type,
            string $validation,
            string $errorMsg
        ) {

            $this -> name = $name;
            $this -> maxLen = $maxLen;
            $this -> type = $type;
            $this -> validation = $validation;
            $this -> errorMsg = $errorMsg;
        }

        public function validate() {

            $value = $this -> value;
            $validation = $this -> validation;

            if($validation == 'age')
                return !($this -> isError = !($value >= 0));

            $isValid = strlen($value) <= $this -> maxLen;
            if($validation == 'username') {

                $isValid = $isValid && preg_match('/^[a-zA-Z0-9_]{3,}$/', $value);
            }
            else if($validation == 'password') {

                $isValid = $isValid && preg_match('/^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/', $value);
            }

            return !($this -> isError = !$isValid);
        }
    };

    $errorMsgs = [

        'username' => 'Username must be between 3-20 characters long & should only contain alphanumerics or underscores!',
        'password' => 'Password must be between 6-30 characters long & should contain uppercase, lowercase letters & numbers!',
        'name' => 'Name cannot exceed 20 characters!',
        'about' => 'About cannot exceed 300 characters!',
        'age' => 'Age Should be a positive number',
        'gender' => 'Gender cannot exceed 20 characters!',
        'email' => 'Email cannot exceed 254 characters!',
        'location' => 'Location cannot exceed 30 characters!'
    ];

    $FIELDS = [

        // 'Field' => FieldObj (  name,  maxLen,  type,      validation, errorMsg)
        'username' => new Field('username', 20 , 'text'    , 'username', $errorMsgs['username']),
        'password' => new Field('password', 30 , 'password', 'password', $errorMsgs['password']),
        'name'     => new Field('name'    , 20 , 'text'    , 'len'     , $errorMsgs['name']),
        'about'    => new Field('about'   , 300, 'text'    , 'len'     , $errorMsgs['about']),
        'age'      => new Field('age'     , 0  , 'number'  , 'age'     , $errorMsgs['age']),
        'gender'   => new Field('gender'  , 20 , 'text'    , 'len'     , $errorMsgs['gender']),
        'email'    => new Field('email'   , 254, 'email'   , 'len'     , $errorMsgs['email']),
        'location' => new Field('location', 30 , 'text'    , 'len'     , $errorMsgs['location']),
    ];

    function getFields(array $fieldNames) {

        global $FIELDS;

        $fields = [];
        foreach($fieldNames as $fieldName)
            $fields[$fieldName] = $FIELDS[$fieldName];

        return $fields;
    }

    function getAllFields() {

        global $FIELDS;
        return $FIELDS;
    }
?>