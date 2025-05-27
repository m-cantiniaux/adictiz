<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\All;
    use Symfony\Component\Validator\Constraints\File;

    class UploadForm extends AbstractType {
        public function buildForm(FormBuilderInterface $builder, array $options) {
            $builder
                ->add('images', FileType::class, [
                    'label' => 'Images (jpeg, png)',
                    'multiple' => true,
                    'mapped' => false,
                    'required' => true,
                    'constraints' => [
                        new All([
                            'constraints' => [
                                new File([
                                    'mimeTypes' => [
                                        'image/png',
                                        'image/jpeg',
                                        'image/jpg',
                                    ],
                                    'mimeTypesMessage' => 'Veuillez uploader un fichier PNG ou JPG valide.',
                                ])
                            ],
                        ]),
                    ],
                ]);
        }
    }
