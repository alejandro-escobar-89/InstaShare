<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link type="image/svg+xml" rel="icon" href="{{ asset('favicon.svg') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>InstaShare API</title>

        <style>
            * {
                scrollbar-color: #565b5d #363839;
            }

            ::selection {
                background-color: #195daf !important;
                color: #e6e4e1 !important;
            }

            html, body, input, textarea, select, button {
                border-color: #7f786c;
                color: #e6e4e1;
            }

            html, body {
                background-color: #2f3031;
            }

            body {
                font-family: 'Arial', sans-serif;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            tr:nth-child(even) {
                background: rgb(69, 73, 75);
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
                background-color: rgb(59, 62, 62);
                border: 2px solid rgb(113, 106, 97);
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
                <p>{{ env('APP_URL') }}/api</p>
            </div>

            <h4>And these are the available endpoints:</h4>

            <div class="gray-container">
                <table>
                    <thead>
                        <tr> <th>Action</th> <th>Method</th> <th>URI</th> <th>Status Code</th> <th>Example</th> </tr>
                    </thead>

                    <tbody>
                        <tr> <td>Registration</td>                           <td>POST</td>        <td>/register</td>                 <td>201</td> <td>{{ env('APP_URL') . '/api/register' }}</td>            </tr>
                        <tr> <td>Login</td>                                  <td>POST</td>        <td>/login</td>                    <td>200</td> <td>{{ env('APP_URL') . '/api/login' }}</td>               </tr>
                        <tr> <td>Logout</td>                                 <td>POST</td>        <td>/logout</td>                   <td>200</td> <td>{{ env('APP_URL') . '/api/logout' }}</td>              </tr>
                        <tr> <td>Obtain the authenticated user's data</td>   <td>GET | HEAD</td>  <td>/user</td>                     <td>200</td> <td>{{ env('APP_URL') . '/api/user' }}</td>            </tr>
                        <tr> <td>List all stored files</td>                  <td>GET | HEAD</td>  <td>/files</td>                    <td>200</td> <td>{{ env('APP_URL') . '/api/files' }}</td>           </tr>
                        <tr> <td>List files owned by the specified user</td> <td>GET | HEAD</td>  <td>/files/owner/{user_id}</td>    <td>200</td> <td>{{ env('APP_URL') . '/api/files/owner/10' }}</td>  </tr>
                        <tr> <td>Upload a new file</td>                      <td>POST</td>        <td>/files</td>                    <td>201</td> <td>{{ env('APP_URL') . '/api/files' }}</td>           </tr>
                        <tr> <td>Obtain the specified file's metadata</td>   <td>GET | HEAD</td>  <td>/files/{file_id}</td>          <td>200</td> <td>{{ env('APP_URL') . '/api/files/123' }}</td>       </tr>
                        <tr> <td>Update the specified file's metadata</td>   <td>PUT | PATCH</td> <td>/files/{file_id}</td>          <td>200</td> <td>{{ env('APP_URL') . '/api/files/456' }}</td>       </tr>
                        <tr> <td>Download the specified file</td>            <td>GET | HEAD</td>  <td>/files/download/{file_id}</td> <td>200</td> <td>{{ env('APP_URL') . '/api/files/456' }}</td>       </tr>
                        <tr> <td>Delete the specified file</td>              <td>DELETE</td>      <td>/files/{file_id}</td>          <td>204</td> <td>{{ env('APP_URL') . '/api/files/789' }}</td>       </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>Note:</strong> If the response fails due to a server error, a <em>500</em>/<em>503</em> status code will be returned. If there's an input error on the user side, a <em>400/422</em> status code will be returned, and a <em>404</em> in case a resource isn't found. <em>401</em> and <em>403</em> status codes will be returned in case there's an unauthorized access to a page or the current user doesn't have permission to access the specified resource.</p>
        </main>
    </body>
</html>
