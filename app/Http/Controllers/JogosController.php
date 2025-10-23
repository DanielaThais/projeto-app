<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //importa a requisição
use App\Models\Jogo; //importa o banco de data do Models
use App\Validator\JogoValidator; //importa nosso Validator

class JogosController extends Controller
{
    public function index()
    {
        // dd('Olá mundo!');
        $jogos = Jogo::all(); //a variável $jogos pesquisa todos os registros pertencentes ao banco de data Jogo
        //dd($jogos);
        return view('jogos.index', ['jogos' => $jogos]); //a função retorna o index e o renderiza como HTML, passando a variável $jogos (atribuindo a chave 'jogos')
    }

    public function create()
    {
        $categorias = Jogo::pluck('categoria')->unique()->sort();
        /*
       *O código acessa a tebal jogos usando o Model Jogo. O método pluck extrai os valores da coluna categorias.
       *O Unique é resposável por filtrar os data e evitar valores duplicados
       *O sort ordena a lita de categorias de forma alfabética
       */
        return view('jogos.create', ['categorias' => $categorias]); //retorna a view jogos.create. O array ['categorias'=>$categorias] passa a variável que foi criada na primeira linha dessa function para a view. Ela é fundamental, pois permite que o formulário de criação use a lista para preenher o menu dropdown com todas as categorias disponíveis. Usamos o ponto para que o comando perceba que dentro de jogos, queremos usar o create
    }

    public function store(Request $request)
    {
        /*
    *Injeção de dependências. Instancia o Request na variável $request. A maneira padronizada e seqgura de acessar todos os data enviados, além da validação de data de entrada, usa automaticamente a csrf e também lida com qualquer tipo de requisição, abstraindo todos os detalhes de como o php lida com as variáveis globais.

    *Jogo::create($request->all()); //retorna todos os data que foram enviados na requisição HTTP, organizando em um array associativo.
    
    *return redirect()->route('jogos.index');//redireciona para a página index através da rota jogos.index ANTIGO CÓDIGO
    */
        $data = $request->all(); //armazenamento dos dados enviados pelo formulário na variável $data

        if (isset($data['valor'])) {
            $data['valor'] = str_replace(',', '.', $data['valor']);
        }
        // o método acima verifica se o campo 'valor' existe nos dados. Caso sim, substitui a virgula por um ponrto, necessário para que os valores decimais sejam convertido para o formato correto que o banco de dados e o php podem entender como um número de ponto flutuante

        $validator = JogoValidator::validate($data); //criação do objeto validator. Essa linha é responsável por chamar o método validate, que foi criada no JogoValidator, passando todos os dados que foram armazenados na variável $data, para que o formulário aceite os dados do usuário.

        if ($validator->fails()) { //condição que verifica se a validação falhou, se algum campo não atendeu às regras.
            return redirect()->route('jogos.create') //se houver erros, o método redireciona o usuário de olta para a página do formulário de criação ('jogos.create')
                ->withErrors($validator) //esse trecho é responsável por enviar mensagens de erro do validador para a view, permitindo que a página de formulário exiba as mensagens para o uusário (indicando o que precisa ser corrigido)
                ->withInput(); //essa função repopula o formulário com os dados que o usuário já havia digitado, para que ele não precise digitar tudo novamente.
        }

        Jogo::create($validator->validated());
        /*Caso os campos não tenham nenhum erro, essa linha cria um novo registro no banco de dados
    *Jogo::create ->comando rsponsável por inserir o novo registro na tabela jogos com os dados já validados

    *($validator->validated()) -> retorna um array contendo apenas os dados que foram validados com sucesso, garantindo que nenhum dado inesperado seja salvo. é como uma prevenção
    */

        return redirect()->route('jogos.index')->with('success', 'Novo jogo adicionado!'); //após o jogo ser salvo com sucesso, o código redireciona o usuário para a página de listagem de jogos index, sendo passada uma mensagem temporária de success para confirmar adição do jogo.

    }

    public function edit($id)
    {
        //$jogos = Jogo::where('id', $id)->first(); //a variável jogos pesquisa em Jogo o id para recebê-lo em $id -> declaração antiga
        $jogos = Jogo::findOrFail($id); //busca o jogo específico com base no ID
        $categorias = Jogo::pluck('categoria')->unique()->sort(); //busca e organiza as categorias, salvando na variável $categorias
        return view('jogos.edit', [
            'jogos' => $jogos,
            'categorias' => $categorias
        ]);
        // if (!empty($jogos)) { //estrutura responsável por verficar se existe a id passada no post, caso exista:
        //     return view('jogos.edit', ['jogos' => $jogos]); //é direcionado para o view de edit para que o contedúdo possa ser alterado
        // } else {
        //     return redirect()->route('jogos.index')->with('success', 'Jogo atualizado!'); //caso a condição não seja atendida, voltamos para o index.
        // }
    }

    public function update(Request $request, $id)
    {
        /*o método recebe dois parâmetros, o request é o objeto que contem todos os dados que foram enviados pelo formulário. Já o id é o responsável por identificar o jogo.
        dd($id);
        *MÉTODO ANTIGO - SEM VALIDATOR
        $data =[
            'nome'=> $request-> nome,
            'categoria'=> $request-> categoria,
            'ano_criacao'=> $request-> ano_criacao,
            'valor'=> $request-> valor,
        ];
        Jogo::where('id', $id)->update($data); // pesquisa através do id selecionado para executar a atualização dos data ($data)
        return redirect()->route('jogos.index'); //redireciona o usuário para a página inicial
        */
        $data = $request->all(); //armazena todos os dados passados pelo formulário na variável $data

        if (isset($data['valor'])) { //verifica se o campo valor foi enviado.
            $data['valor'] = str_replace(',', '.', $data['valor']); //caso tenha sido enviado, ele faz a substituição da vírgula pelo ponto, como mencionado anteriormente.
        }


        $validator = JogoValidator::validate($data); //verificação dos dados através do validate de JogoValidator através do objeto validator

        if ($validator->fails()) { //tratamento de erros, verificando se alguma regra falhou (caso nem todas elas tenham sido atendidas corretamente)
            return redirect()->route('jogos.edit', $id) //o usuário é redirecionado para a página de edição de jogos, o id é passado para garantir que seja redirecionado para o jogo correto
                ->withErrors($validator) //anexa a mensagem de erro do validator através da view
                ->withInput(); //preenche os dados que o usuário já havia passado
        }

        
        Jogo::where('id', $id)->update($validator->validated());
        return redirect()->route('jogos.index')->with('success', 'Jogo atualizado com sucesso!'); //caso não haja nenhum erro de validação, o usuário atualiza o jogo e é redirecionado para o index novamente


    }

    public function destroy($id)
    {
        $jogo=Jogo::findOrFail($id); //recebe o jogo através da busca
        $nome=$jogo->nome; //armazena o nome do jogo em uma variável 
        $jogo->delete(); //deleta o jogo
        return redirect()->route('jogos.index')->with('danger', 'O jogo "' .$nome. '" foi deletado.'); //redireciona o usuário para a página index  e emite a mensagem confirmando que o jogo foi deletado
    }
}
