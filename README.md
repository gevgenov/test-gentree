# test-gentree
Тестовое задание на построение и сериализацию дерева.

Чтобы собрать и развернуть проект локально:
```shell
$ ./appctl install
```

Запуск консоли:
```shell
$ ./appctl sh
```

Остановка контейнера и удаление всех связанных данных:
```shell
$ ./appctl uninstall
```

Пример выполнения приложения:
```shell
$ ./appctl sh
Running the shell...
$ ./bin/gentree storage/input.csv storage/gentree.output.json
$ cat storage/gentree.output.json | jq --sort-keys | md5sum
9b1643d9db23c5784d1243733fad6654  -
$ cat storage/output.json | jq --sort-keys | md5sum
9b1643d9db23c5784d1243733fad6654  -
```
