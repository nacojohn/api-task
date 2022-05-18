<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## How to setup, run and test the Project

1. Pull the repository
2. Make a duplicate of `.env.example` and rename it to `.env`
3. Edit the DB and Email Connections (You can use [Mailtrap](https://mailtrap.io))
4. Run `composer install` command
5. Run `php artisan migrate --seed` to run the migration and seed the tables
6. Run `php artisan serve` and make sure it's running on port 8000, else you will have to edit the `url` variable in the Postman Collection
7. To test the application, kindly use the login details: \
    **Email:** test@example.com \
    **Password:** password
8. On successful login, copy the token generate
9. Download the Postman collection and edit the `token` variable by replacing the token with the one generated.

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/ead5aeff6fee37c1d069)

## Table of Contents
- [Response Format](#response-format)
- [Response Code](#response-codes)
- [Headers](#headers)
- [API Endpoints](#api-endpoints)
    1. [Login](#login)
    2. [Get Medical Categories](#get-medical-categories)
    3. [Create Medical Record](#create-medical-record)
    4. [Retrieve Medical Records](#retrieve-medical-records)
- [GraphQl Endpoints](#graphql)
    1. [Login](#graphql-login)
    2. [Get Medical Categories](#graphql-medical-categories)
    3. [Create Medical Record](#graphql-create-medical-record)
    4. [Retrieve Medical Records](#graphql-retrieve-medical-records)

## Response Format

For every successful request with a 200 or 201 response code, the response is formatted like this:

                {
                    "success": true (boolean),
                    "data": (null or an object),
                    "message": (string)
                }

For every failed request, the response is formatted like this:

                {
                    "success": false (boolean),
                    "message": (string),
                    "data": (null or an object)
                }

## Response Codes

200 - OK \
201 - OK \
429 - Too much request, try again after 30 secs \
401 - Unauthorized \
422 - Unprocessed request due to invalid data

## Headers

- `Accept` set to `application/json`
- `Authorization` set to `Bearer {TOKEN}` where required

## API Endpoints

URL: `http://127.0.0.1:8000/api/`

#### Login

- Endpoint: `{URL}+'login'`
- Method: `POST`
- Body:

                {
                    'email' => 'required' (can be username, email or phone),
                    'password' => 'required'
                }

- Successful Response:

                {
                    "success": true,
                    "data": {
                        "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxx"
                    },
                    "message": "Logged in successfully"
                }

#### Get Medical Categories

- Endpoint: `{URL}+'medical-categories'`
- Method: `GET`
- Header: `Authorization`: `Bearer {token}`
- Failed Response

                {
                    "message": "Unauthenticated."
                }

- Successful Response

                {
                    "success": true,
                    "data": [
                        {
                            "id": 1,
                            "title": "X-Ray",
                            "laboratory_tests": [
                                {
                                    "id": 1,
                                    "laboratory_category_id": 1,
                                    "title": "Chest"
                                },
                                {
                                    "id": 2,
                                    "laboratory_category_id": 1,
                                    "title": "cervical vertebrae"
                                },
                                {
                                    "id": 3,
                                    "laboratory_category_id": 1,
                                    "title": "thoracic vertebrae"
                                },
                            ]
                        },
                        {
                            "id": 2,
                            "title": "Ultrasound Scan",
                            "laboratory_tests": [
                                {
                                    "id": 10,
                                    "laboratory_category_id": 2,
                                    "title": "breast"
                                },
                                {
                                    "id": 11,
                                    "laboratory_category_id": 2,
                                    "title": "pelvis"
                                },
                                {
                                    "id": 12,
                                    "laboratory_category_id": 2,
                                    "title": "prostrate"
                                },
                                {
                                    "id": 13,
                                    "laboratory_category_id": 2,
                                    "title": "thyroid"
                                }
                            ]
                        }
                    ],
                    "message": "Retrieved successfully"
                }

#### Create Medical Record

- Endpoint: `{URL}+'medical-record'`
- Method: `POST`
- Header: `Authorization`: `Bearer {token}`
- Failed Response

                {
                    "message": "Unauthenticated."
                }

- Body

                {
                    'tests' => 'required|array',
                    'ctscan' => 'required',
                    'mri' => 'required'
                }

    **Note:** `tests` is an array of Laboratory Test IDs retrieved using the [Get Medical Categories](#get-medical-categories) endpoint in this format `[1, 5, 39, 2]`

- Successful Response

                {
                    "success": true,
                    "data": {
                        "patient": {
                            "id": 1,
                            "name": "Test User",
                            "email": "test@example.com"
                        },
                        "tests": {
                            "X-Ray": [
                                {
                                    "id": 3,
                                    "laboratory_category_id": 1,
                                    "title": "Thoracic Vertebrae"
                                },
                                {
                                    "id": 4,
                                    "laboratory_category_id": 1,
                                    "title": "Lumvar Vartebrae"
                                },
                                {
                                    "id": 6,
                                    "laboratory_category_id": 1,
                                    "title": "Wrist Joint"
                                }
                            ]
                        },
                        "ctscan": "A Scan",
                        "mri": "An Mri Scan",
                        "date_added": "6 seconds ago"
                    },
                    "message": "Record saved successfully"
                }

#### Retrieve Medical Records

- Endpoint: `{URL}+'medical-record'`
- Method: `GET`
- Header: `Authorization`: `Bearer {token}`
- Failed Response

                {
                    "message": "Unauthenticated."
                }

- Successful Response

                {
                    "success": true,
                    "data": [
                        {
                            "patient": {
                                "id": 1,
                                "name": "Test User",
                                "email": "test@example.com"
                            },
                            "tests": {
                                "X-Ray": [
                                    {
                                        "id": 3,
                                        "laboratory_category_id": 1,
                                        "title": "Thoracic Vertebrae"
                                    },
                                    {
                                        "id": 4,
                                        "laboratory_category_id": 1,
                                        "title": "Lumvar Vartebrae"
                                    },
                                    {
                                        "id": 6,
                                        "laboratory_category_id": 1,
                                        "title": "Wrist Joint"
                                    },
                                    {
                                        "id": 8,
                                        "laboratory_category_id": 1,
                                        "title": "Fingers"
                                    },
                                    {
                                        "id": 9,
                                        "laboratory_category_id": 1,
                                        "title": "Toes"
                                    }
                                ],
                                "Ultrasound Scan": [
                                    {
                                        "id": 12,
                                        "laboratory_category_id": 2,
                                        "title": "Prostrate"
                                    }
                                ]
                            },
                            "ctscan": "A Scan",
                            "mri": "An Mri Scan",
                            "date_added": "25 minutes ago"
                        },
                        {
                            "patient": {
                                "id": 1,
                                "name": "Test User",
                                "email": "test@example.com"
                            },
                            "tests": {
                                "X-Ray": [
                                    {
                                        "id": 3,
                                        "laboratory_category_id": 1,
                                        "title": "Thoracic Vertebrae"
                                    },
                                    {
                                        "id": 4,
                                        "laboratory_category_id": 1,
                                        "title": "Lumvar Vartebrae"
                                    },
                                    {
                                        "id": 6,
                                        "laboratory_category_id": 1,
                                        "title": "Wrist Joint"
                                    }
                                ]
                            },
                            "ctscan": "A Scan",
                            "mri": "An Mri Scan",
                            "date_added": "14 seconds ago"
                        }
                    ],
                    "message": "Records retrieved successfully"
                }

## GraphQl Endpoints

URL: `http://127.0.0.1:8000/graphql` \
Method: `POST`

#### Graphql Login

- Body:

                mutation {
                    login(email:"test@example.com", password:"password")
                }

- Successful Response:

                {
                    "data": {
                        "login": "1|xxxxxxxxxxxxxxxxxxxxxxxxxx"
                    }
                }

#### Graphql Medical Categories

- Header: `Authorization`: `Bearer {token}`
- Body:

                {
                    medical_categories {
                        id
                        title
                        tests {
                        id
                        title
                        }
                    }
                }

- Successful Response

                {
                    "data": {
                        "medical_categories": [
                            {
                                "id": "1",
                                "title": "X-Ray",
                                "tests": [
                                    {
                                        "id": "1",
                                        "title": "Chest"
                                    },
                                    {
                                        "id": "2",
                                        "title": "Cervical Vertebrae"
                                    },
                                    {
                                        "id": "3",
                                        "title": "Thoracic Vertebrae"
                                    },
                                    {
                                        "id": "4",
                                        "title": "Lumvar Vartebrae"
                                    },
                                ]
                            },
                            {
                                "id": "2",
                                "title": "Ultrasound Scan",
                                "tests": [
                                    {
                                        "id": "10",
                                        "title": "Breast"
                                    },
                                    {
                                        "id": "11",
                                        "title": "Pelvis"
                                    },
                                    {
                                        "id": "12",
                                        "title": "Prostrate"
                                    }
                                ]
                            }
                        ]
                    }
                }

#### Graphql Create Medical Record

- Header: `Authorization`: `Bearer {token}`
- Body:

                mutation {
                    add_medical_record(
                        tests: [1,4,6]
                        ctscan: "new scan"
                        mri: "new mri scan"
                    ) {
                        id
                        patient {
                            id
                            name
                            email
                        }
                        tests
                        ctscan
                        mri
                        date_added: created_at
                    }
                }

- Successful Response

                {
                    "data": {
                        "add_medical_record": {
                            "id": "3",
                            "patient": {
                                "id": "1",
                                "name": "Test User",
                                "email": "test@example.com"
                            },
                            "tests": "{\"X-Ray\":[{\"id\":1,\"laboratory_category_id\":1,\"title\":\"Chest\"},{\"id\":4,\"laboratory_category_id\":1,\"title\":\"Lumvar Vartebrae\"},{\"id\":6,\"laboratory_category_id\":1,\"title\":\"Wrist Joint\"}]}",
                            "ctscan": "New Scan",
                            "mri": "New Mri Scan",
                            "date_added": "2022-05-18 18:57:16"
                        }
                    }
                }

#### Graphql Retrieve Medical Records

- Header: `Authorization`: `Bearer {token}`
- Body:

                {
                    medical_records {
                        id
                        patient {
                            id
                            name
                            email
                        }
                        tests
                        ctscan
                        mri
                        date_added: created_at
                    }
                }

- Successful Response

                {
                    "data": {
                        "medical_records": [
                            {
                                "id": "1",
                                "patient": {
                                    "id": "1",
                                    "name": "Test User",
                                    "email": "test@example.com"
                                },
                                "tests": "{\"X-Ray\":[{\"id\":3,\"laboratory_category_id\":1,\"title\":\"Thoracic Vertebrae\"},{\"id\":4,\"laboratory_category_id\":1,\"title\":\"Lumvar Vartebrae\"},{\"id\":6,\"laboratory_category_id\":1,\"title\":\"Wrist Joint\"},{\"id\":8,\"laboratory_category_id\":1,\"title\":\"Fingers\"},{\"id\":9,\"laboratory_category_id\":1,\"title\":\"Toes\"}],\"Ultrasound Scan\":[{\"id\":12,\"laboratory_category_id\":2,\"title\":\"Prostrate\"}]}",
                                "ctscan": "A Scan",
                                "mri": "An Mri Scan",
                                "date_added": "2022-05-18 10:56:50"
                            },
                            {
                                "id": "2",
                                "patient": {
                                    "id": "1",
                                    "name": "Test User",
                                    "email": "test@example.com"
                                },
                                "tests": "{\"X-Ray\":[{\"id\":3,\"laboratory_category_id\":1,\"title\":\"Thoracic Vertebrae\"},{\"id\":4,\"laboratory_category_id\":1,\"title\":\"Lumvar Vartebrae\"},{\"id\":6,\"laboratory_category_id\":1,\"title\":\"Wrist Joint\"}]}",
                                "ctscan": "A Scan",
                                "mri": "An Mri Scan",
                                "date_added": "2022-05-18 11:21:43"
                            }
                        ]
                    }
                }


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
