<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */

/**
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
 class VisiteRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    /**
     * Retourne toute les visites triées sur un champ
     * @param type $champ
     * @param type $ordre
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $ordre): array{
        return $this->createQueryBuilder('v') // v = alias de la table 
                ->orderBy('v.'. $champ, $ordre)
                ->getQuery()
                ->getResult();
    }
    
    /**
     * Enregistrements dont un champ est égal a une valeur 
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur) : array{
        if($valeur==""){
            return $this->createQueryBuilder('v') // v = alias de la table 
                ->orderBy('v.'.$champ, 'ASC')
                ->getQuery()
                ->getResult();
        }else{
            return $this->createQueryBuilder('v') // v = alias de la table 
                ->where('v.'.$champ.'=:valeur')
                ->setParameter('valeur', $valeur)
                ->orderBy('v.datecreation', 'DESC')
                ->getQuery()
                ->getResult();
            }
    }
    
    public function remove(Visite $visite): void{
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
    
    public function add(Visite $visite): void{
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }
    
    /**
     * Retourne les n visites les plus récentes
     * @param type $nb
     * @return Visite[]
     */
    public function findAllLasted($nb) : array {
        return $this->createQueryBuilder('v') // alias de la table
           ->orderBy('v.datecreation', 'DESC')
           ->setMaxResults($nb)     
           ->getQuery()
           ->getResult();
    }
}
