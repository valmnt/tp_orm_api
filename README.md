# TP ORM/API Mont Valentin

## Quel est l'intérêt de créer une API plutôt qu'une application classique ?

L'intérêt de créer une API est de pouvoir changer l'application Front-end sans à avoir à refaire le backend.

## Résumez les étapes du mécanisme de sérialisation implémenté dans Symfony

2 etapes : 
    normalisation: transforme les objets en tableau
    encodage:  transforme le tableau en JSON ou XML

## Qu'est-ce qu'un groupe de sérialisation ? A quoi sert-il ?

Les groupes de sérialization permettent de pouvoir afficher les divers attributs compris dans le groupes.
Cela afin d'éviter une sérialisation circulaire.

## Quelle est la différence entre la méthode PUT et la méthode PATCH ?

La méthode PUT écrase toutes les données alors que PATCH remplace uniquement les données modifiées.

## Quels sont les différents types de relation entre entités pouvant être mis en place avec Doctrine ?

ManytoMany
ManyToOne
OneToMany

## Qu'est-ce qu'un Trait en PHP et à quoi peut-il servir ?

Un Trait ressemble à une classe mais s'en ai pas une, ça regroupe des fonctionnalités qui peuvent être réutilisé dans le code de l'application.