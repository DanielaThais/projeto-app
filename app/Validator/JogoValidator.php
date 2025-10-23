<?php

namespace App\Validator; //endereço do arquivo

use Illuminate\Support\Facades\Validator; //importando a classe Validator do Laravel. O "Facades" permite que sejam chamados os métodos estáticos sem a necessidade de criar uma nova instância

class JogoValidator  
{
    /**
     * Valida os dados para a criação ou atualização de um jogo.
     *
     * @param array $data Os dados vindos do request. Descreve o parâmetro que o método espera, que no caso é o array $data
     * @return \Illuminate\Contracts\Validation\Validator O objeto do validador. Descreve o tipo de dado que o método retorna, no caso, objeto de validação do Laravel.
     */
    public static function validate(array $data) //definição da function como estática, conforme assegurado pelo Facades, permitindo que não seja necessário criar um objeto da classe (new JogoValidador()) para usar esse método, podendo ser chamado abaixo (JogoValidador::validate()). Conforme descrito anteriormente, o método recebe o array data como parâmetro.
    {
        $rules = [ //definifção do array de regras de validação (rules= regras)
            'nome' => 'required|min:3|max:255', //determina que a regra é que esse campo deve receber o dado em string, com no mínimo 3 letras e no máximo 255, jamais podendo estar vazio (required)
            'categoria' => 'required|min:3|max:100', //idem
            'ano_criacao' => 'required|integer|min:1950|max:'.date('Y'), //determina que o dado recebido não pode ser maior que o ano atual (.date(Y)) e o ano mínimo deve ser 1950.
            'valor' => 'required|numeric|min:0'
        ];

        $messages = [ //define o array de mensagens de erro personalizadas, ao invés de usar as padrões do Laravel.
            'nome.min' => 'O campo nome deve ter no mínimo :min caracteres.', //nesse caso seja impressa a mensagem com base no que foi passado como valor mínimo de caracteres definido anteriormente (3).
            'nome.required' => 'O campo nome é obrigatório.',
            'categoria.required' => 'O campo categoria é obrigatório.',
            'ano_criacao.required' => 'O campo ano de criação é obrigatório.',
            'ano_criacao.integer' => 'O ano de criação deve ser um número inteiro.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O campo valor deve ser um número.'
        ];

        return Validator::make($data, $rules, $messages); //cria e retorna o objeto de validação
        /*
        Validator::make() -> é o método estático que cria uma nova instância do validator
        $data -> o primeiro array de data que quero validar
        $rules -> o segundo parâmetro são as regras de valição definidas anteriormente
        $messages -> terceiro parâmetro são as mensagens de erro que personalizei.
        */
    }
}