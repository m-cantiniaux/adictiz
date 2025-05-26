<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class UploadForm extends AbstractType {
        public function buildForm(FormBuilderInterface $builder, array $options) {
            $builder
                ->add('images', FileType::class, [
                    'label' => 'Upload Images',
                    'multiple' => true,
                    'mapped' => false,
                    'required' => true,
                ]);
        }
    }
