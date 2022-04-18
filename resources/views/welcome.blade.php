<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link type="image/svg+xml" rel="icon" href="{{ asset('favicon.svg') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>InstaShare API</title>

        <style>
            body {
                font-family: 'Arial', sans-serif;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            tr:nth-child(even) {
                background: #d2d2d2;
            }

            th {
                text-align: left;
                border-bottom: 2px solid #9d9d9d;
                margin-bottom: 1em;
            }

            th, td {
                padding: 8px;
            }

            .text-center {
                text-align: center;
            }

            .underline {
                text-decoration: underline;
            }

            .gray-container {
                background: #e7e7e7;
                border: 2px solid #7c7c7c;
                border-radius: 5px;
                padding: 1em;
                margin-bottom: 2.5em;
                overflow: auto;
            }

            .gray-container p {
                margin: 0 !important;
            }

            .mb-2 {
                margin-bottom: 1.5em;
            }

            @media (min-width: 1024px) {
                .container {
                    padding: 0.5em 12%;
                }
            }
        </style>
    </head>

    <body>
        <main class="container">
            <h1 class="text-center underline mb-2">Welcome to the InstaShare API</h1>

            <h4>The base URL for our web service is:</h4>

            <div class="gray-container">
                <p>{{ env('APP_URL') }}</p>
            </div>

            <h4>And these are the available endpoints:</h4>

            <div class="gray-container">
                <table>
                    <thead>
                        <tr> <th>Action</th> <th>Method</th> <th>URI</th> <th>Status Code</th> <th>Example</th> </tr>
                    </thead>

                    <tbody>
                        <tr> <td>Registration</td>                         <td>POST</td>        <td>register</td>            <td>200</td> <td>{{ env('APP_URL') . '/register' }}</td>            </tr>
                        <tr> <td>Create a CSRF cookie before login</td>    <td>GET | HEAD</td>  <td>sanctum/csrf-cookie</td> <td>200</td> <td>{{ env('APP_URL') . '/sanctum/csrf-cookie' }}</td> </tr>
                        <tr> <td>Login</td>                                <td>POST</td>        <td>login</td>               <td>200</td> <td>{{ env('APP_URL') . '/login' }}</td>               </tr>
                        <tr> <td>Logout</td>                               <td>POST</td>        <td>logout</td>              <td>200</td> <td>{{ env('APP_URL') . '/logout' }}</td>              </tr>
                        <tr> <td>Obtain current user's data</td>           <td>GET | HEAD</td>  <td>api/user</td>            <td>200</td> <td>{{ env('APP_URL') . '/api/user' }}</td>            </tr>
                        <tr> <td>List all stored files</td>                <td>GET | HEAD</td>  <td>api/files</td>           <td>200</td> <td>{{ env('APP_URL') . '/api/files' }}</td>           </tr>
                        <tr> <td>Upload a new file</td>                    <td>POST</td>        <td>api/files</td>           <td>201</td> <td>{{ env('APP_URL') . '/api/files' }}</td>           </tr>
                        <tr> <td>Obtain the specified file's data</td>     <td>GET | HEAD</td>  <td>api/files/{file_id}</td> <td>200</td> <td>{{ env('APP_URL') . '/api/files/123' }}</td>       </tr>
                        <tr> <td>Update the specified file's metadata</td> <td>PUT | PATCH</td> <td>api/files/{file_id}</td> <td>200</td> <td>{{ env('APP_URL') . '/api/files/456' }}</td>       </tr>
                        <tr> <td>Delete the specified file</td>            <td>DELETE</td>      <td>api/files/{file_id}</td> <td>204</td> <td>{{ env('APP_URL') . '/api/files/789' }}</td>       </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>Note:</strong> If the response fails due to a server error, a 500/503 status code will be returned. If a resource is not found, a 404 status code will be returned.</p>
        </main>
    </body>
</html>
