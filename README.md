# TourRadar

## Software Engineer Test Case

This test case consists of 2 parts:

- [The architecture challenge](#the-architecture-challenge)
- [The coding challenge](#the-coding-challenge)

## The Architecture challenge

![current-architecture](storage/images/finance-task.jpg)

We have an issue related to our application load because of the huge amount of HTTP requests it receives. Those requests could be potentially processed asynchronously, as the client doesn't care about the response from our API gateway endpoint. Having that in mind, we decided to improve our application architecture by integrating a queue into the current system.

### The assignment

You need to help us to build a new architecture design, where we will have a queue for collecting the requests, and a PHP application for consuming the messages from that queue. We need to make sure the application is consuming messages correctly and keeps track of errors. Sometimes there might be a timeout and then, after 1 minute, the same request would work again. Please write down a way of handling such cases.

From the consumer perspective, you should expect `GET` requests to an external API and a `POST` request to our internal API.

The architecture should be based on cloud services, be resilient and performant.

Please, provide the architecture design as a diagram. You can include the image directly, or a shareable link to diagrams.net or other preferred service.

Include a description of the architecture, and explain the motivations behind the choices made.

## The coding challenge

The command `banned-users:get` in the Laravel project in this repository has been poorly implemented. 
There are several problems with the code quality, and the stakeholders reported that it also doesn't always output the correct results.

Its target is to get all the users that have been banned from the platform.
It must accept some parameters:
- `--no-admin`, get all the users that have been banned and have no related `admin` role;
- `--admin-only`, get all the users that have been banned and have related `admin` role;
- `--active-users-only`, get all the users that have been banned and that have been activated;
- `--with-trashed`, get all the users that have been banned and that have been both deleted or not;
- `--trashed-only`, get all the users that have been banned and that have been both deleted;
- `--with-headers`, if set, print and save the column headers too;
- `sort-by={field-name}` (optional), the field on which sort the output;
- `save-to={output/file/absolute/path}`, if set, save the list on output file too.

It must output a list of sorted users, each one in a new line, indicating users' `email`, `id` and the date of the ban.

### The assignment

You are required to:

1. Identify and correct all problems in the current source code.
2. Improve the coding style and make it compliant with the PSR guidelines.
3. Refactor the logic in the command to use services or helpers according to Laravel best practices.
4. Write unit tests for all the code you will implement.

Consider matching at least a 90% lines of code coverage. If you think it's not possible to reach it, please explain why.


### The Architecture challenge answer

I've made the solution of the Architecture challenge on diagrams.net. I've write the explanation, and the flow on the same diagramm.

https://viewer.diagrams.net/?tags=%7B%7D&highlight=0000ff&edit=_blank&layers=1&nav=1#R7RvbcuI29GuYaR%2BS8QUMPCYk2d3udktCOuk%2BdYQtgxbZYiU5hH59dfPdybqzATGbvgA%2BkqxzP0fniIE%2FS57eUbBd%2F04iiAeeEz0N%2FKuB53nOeCi%2BJGSvIRPH14AVRZEGuSVggf6BBugYaIYiyGoTOSGYo20dGJI0hSGvwQClZFefFhNc33ULVrAFWIQAt6EPKOJrQ4U3LuHvIVqt853dYKpHEpBPNpSwNYjIrgLyrwf%2BjBLC9a%2FkaQaxZF7OF73u5pnRAjEKU95nwdx9uCfbvz%2Bj5bvNb%2FH1Jrq9%2FXxmkGV8nxMMI0G%2FeSSUr8mKpABfl9BLSrI0gvKtjngq53wiZCuArgB%2BhZzvjTBBxokArXmCzahAmO7%2FMuvVwxf5cD7KH6%2BeqoNXe%2FOkcZUIPssCA2IkoyF8ge5clQBdQf7CvFEhKKHhkCRQ4CPWUYgBR491PIBRtVUxr5SG%2BGEE8h%2BEY977CHBmdrqYf2gJrC6O3RpxuNgCRf1O2GSd9eaNkHL49DIT20TnC6ZGoY1FB%2BZxV5qHm%2Bv8umIa%2BbxXZ9PQafHkqEpc6u2XmtoeXIm9nkrs21Rir6XEHy9uPl5YV2M%2FqKuxO7atx37b3B8WAy8AiaQ%2BXTL5tbhdnBzrvKlt1nmjN%2BoChj1dgGfVBwz9UxKPe3risSudlt%2BZv58LwMV2i1EoECDpybmcodfT5QwP5q0tp87WXM6or8uxqdOjPrH0E0iWETg53baeUAd9mDfDJIseAA%2FX1hlYHLELBtrm4MjKkeQVjXzS08iHU5tWPumjqAsOt03YTZaGMq6xgVSLG%2FH5EcQb4QqcuwIxmxodTE5No922U2hx6Tt8AWyrK3QxepK8fJVihFvj06TjJDJxgjafCuDrM2rcwagAi30vYyKIqnIs%2BJaRfOCMKbMWB2PHDbZPij35uPi1kt%2F3ayQ1FtBQcjrkGYUSHQmLIEOrVLBV1kclsSCNsByVSr0WhEuUCM4SCSOx%2BHh%2Ffz9Xlvotg4yzfCFIZeon60zOCnC4A%2Ftz8fN%2BDdsbZxxhgTRT1FJEMvlLWaDDIH1EISzfKhbCR7mIhQCDpVjIBa9n2lWgGkBgLj5jkGGulmNIQRrC85yNQiyak5opLTUU2sTrmsc4JRs4I5hQAUlJKt1tjDBugAAWPBSPodA%2BKOCXUjdFCowvzECCokj56i5VrzuJ10gMnO8q93jS4QRc52DnbMulNnv14mnPgPiMRI9UMJ62fI%2Bx8rvr2z%2BvF%2FfWA1srU7Mc1nIKOrx1hB47nbV0L2fGU0hv%2FTVjHMV7xR%2BnryfPN8lwE4JRE8K2yie3MVmCcLNSEjwLtSOTe6IUcQRw57YzjKCOQTCNWO7t65Egd9lcuXwdCd4VkUCjtKRNJAX3NZ4tcJugg5KoI5WOQvkBz4lNvieDGtSxTk0TZgkfgeJIBLiaSUlSGTYcKcPSNltixGQ0RQWnVO543swxn%2BfMc9OOzKk85aUwhMI1RQXZmhWKZoxlB9WkEyhdKVvlknwsPWGRVLA8qzBszCeRnZrKYRruz39MV7RIVf1bkE8oLMWI0piUsjN0SfxDkuEon6%2F9h86IBMZMdn7VLKUXEiqknclpVVX%2FDlZa3ToKZjOFHeAVLJawyK8ULdcYCNcRil%2BXEKSMA7zR61akzJw0hZpsrYKhOLfoPE5EUgZLauSaX0oZ%2FNqXhg9ScCQMM5rjBykVGmRoUFhXSRNiXbHcAhSAV4yuWhjov714Q5nMpqTEwVlmvDkuqeMogSQztplI%2FpUMb1ivmis5V8xHcsudnBSuieZh4wBoRhU3BMNjtNI5r5JJPkfvEwOETeK9ldJUhhPLBNJw05UYolTkNUyPapI6kFBvz1jJTH14dSrn1Ype7ap6JVYVyT8RebqgnAq7K7DcEbqJlT2WUpX%2BUVuripQU0ixlbbrqbtBQVhAFXxSzALZjnACq6HqwBB7DmFtP391hLddxnY6a9TjoOJy6Bytae4Hd%2FN1eq9zvmb8HNvN333KfzNrxqrd4fKtdhRzNasGxEi5NDPVv2sesNUmWGTvKEctv1A5HHW6nq2owOZjTaVfE7orQPKckFNmLjDOWj6bDxr2m8dD64bR9nL%2BnMkH9eQteDdX12yIIOiTgH0oCfrs8cAMwO1URUMJ1iu5fTV9JJMNxQyQdJZvjisTyVR9rMdL3esbIidUU5q1mmL3Fo8OhNfl47ZhiTtKW85aR2%2FA0nb28I%2BYtfjtveWPOf9ToQAUdIjmu8293%2FH%2FujChoZERdFwGOKoFhh%2F%2F4Y%2F5hdqIiOERG1BCJ13FOOKpIRnarBsXD0TOiYd%2Bm7I%2F%2Bi0ctvaAU7CsTtgSlspVUvHkuAaWeFOdHoydTpyFp%2FcJS7gVmP6AKw%2F9V4YRvpQ7bB%2Fpm20HVkcraf6XwbzE1C0ajmiq7XX%2F4GHf4vMNVskftG77Wr1lhohpi8aB2q%2BpbhsINVp5Dte%2F0fSesrlVdSnDGdGO10rdUnTXdfOqxg2y2qtaWwzDZ6ZdFZJeeDzquYyVgA%2FMdIGD7nJIEpKoharBcUdW61Z0gtmccJuU9MP3cRlHVQVnxDukpEqBCN9ZGlhtbeeVMd7LWQN0Nq%2FTp3t5tL6%2FRLvK62kWvdd1LPJb%2FPNbRp%2Fz%2Ftn%2F9Lw%3D%3D


