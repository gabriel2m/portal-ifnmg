@extends('layouts.main')

@php($pageTitle[] = 'Pesquisa Avançada')

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title')
        <p class="text-xl">
            A pesquisa avançada usa uma sintaxe simples e tolerante a falhas para analisar e dividir o texto da consulta em
            termos com base em operadores especiais. A consulta analisa cada termo independentemente antes de retornar os
            perfis correspondentes.
        </p>
        <h3 class="mt-5 mb-3">
            Sintaxe
        </h3>
        <p>
            Os seguintes operadores são suportados:
        </p>
        <table class="table-auto bg-white text-slate-700 table-primary">
            <thead>
                <tr>
                    <th>
                        Operador
                    </th>
                    <th>
                        Definição
                    </th>
                    <th>
                        Exemplo
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        +
                    </td>
                    <td>
                        Operação AND
                    </td>
                    <td>
                        IFNMG + Januária
                    </td>
                </tr>
                <tr>
                    <td>
                        |
                    </td>
                    <td>
                        Operação OR
                    </td>
                    <td>
                        IFNMG | Januária
                    </td>
                </tr>
                <tr>
                    <td>
                        -
                    </td>
                    <td>
                        Operação NOT
                    </td>
                    <td>
                        IFNMG - Januária
                    </td>
                </tr>
                <tr>
                    <td>
                        "
                    </td>
                    <td>
                        Encapsula uma sequencia de palavras
                    </td>
                    <td>
                        "IFNMG Campus Januária"
                    </td>
                </tr>
                <tr>
                    <td>
                        *
                    </td>
                    <td>
                        No final de um termo determina um prefixo
                    </td>
                    <td>
                        IF*
                    </td>
                </tr>
                <tr>
                    <td>
                        ( )
                    </td>
                    <td>
                        Determina precedencia
                    </td>
                    <td>
                        (IFNMG | Januária) - Campus
                    </td>
                </tr>
                <tr>
                    <td>
                        ~N
                    </td>
                    <td>
                        após uma palavra significa o número de caracteres que podem ser corrigidos (fuzzi),
                        sendo N um número inteiro
                    </td>
                    <td>
                        Januriá~2
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
