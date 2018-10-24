<?php
namespace App\Http\Requests;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Validation\ValidatesWhenResolvedTrait;

/**
 * Class FormRequest
 *
 * @package App\Http\Requests
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-24 11:27:56
 */
abstract class Request extends IlluminateRequest implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    /**
     * The container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }

        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->all();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exception\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return new JsonResponse($errors, 200);
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return ['code' => 500,
                'msg'  => $validator->messages()
                                    ->first()
        ];
    }

    /**
     * Set the container implementation.
     *
     * @param  \Illuminate\Container\Container $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    abstract public function messages();

    abstract public function rules();

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}