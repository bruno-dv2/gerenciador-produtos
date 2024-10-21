<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|unique:produtos,nome|string|max:125',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.unique' => 'Já existe um produto com este nome.',
            'descricao.required' => 'A descrição do produto é obrigatória.',
            'categoria_id.required' => 'A categoria do produto é obrigatória.'
        ];
    }
}
